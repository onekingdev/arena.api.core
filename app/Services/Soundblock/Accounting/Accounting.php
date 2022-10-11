<?php

namespace App\Services\Soundblock\Accounting;

use Carbon\Carbon;
use App\Facades\Soundblock\Accounting\Charge;
use App\Exceptions\Core\Disaster\PaymentTaskException;
use Laravel\Cashier\{Exceptions\IncompletePayment, PaymentMethod};
use App\Contracts\Soundblock\Accounting\Accounting as AccountingContract;
use App\Models\{
    Soundblock\Accounts\Account,
    Soundblock\Accounts\AccountTransaction,
    Users\User};
use App\Repositories\{
    Accounting\AccountingInvoice as AccountingInvoiceRepository,
    Accounting\AccountingFailedPayments,
    Common\Account as AccountRepository,
    Soundblock\ProjectsBandwidth,
    Soundblock\Reports\DiskSpace as DiskSpaceRepository,
    Soundblock\AccountInvoice as AccountInvoiceRepository
};

class Accounting implements AccountingContract {
    /** @var bool */
    private bool $chargeNotDefault;
    /** @var AccountingInvoiceRepository */
    private AccountingInvoiceRepository $accountingInvoiceRepository;
    /** @var AccountingFailedPayments */
    private AccountingFailedPayments $accountingFailedPaymentsRepository;
    /** @var ProjectsBandwidth */
    private ProjectsBandwidth $projectsBandwidthRepo;
    /** @var AccountRepository */
    private AccountRepository $accountRepository;
    /** @var AccountInvoiceRepository */
    private AccountInvoiceRepository $accountInvoiceRepo;
    /**
     * @var DiskSpaceRepository
     */
    private DiskSpaceRepository $diskSpaceRepo;

    /**
     * AccountingService constructor.
     * @param bool $chargeNotDefault
     * @param AccountingInvoiceRepository $accountingInvoiceRepository
     * @param AccountingFailedPayments $accountingFailedPaymentsRepository
     * @param ProjectsBandwidth $projectsBandwidthRepo
     * @param AccountRepository $accountRepository
     * @param AccountInvoiceRepository $accountInvoiceRepo
     * @param DiskSpaceRepository $diskSpaceRepo
     */
    public function __construct(bool $chargeNotDefault, AccountingInvoiceRepository $accountingInvoiceRepository,
                                AccountingFailedPayments $accountingFailedPaymentsRepository, ProjectsBandwidth $projectsBandwidthRepo,
                                AccountRepository $accountRepository, AccountInvoiceRepository $accountInvoiceRepo, DiskSpaceRepository $diskSpaceRepo) {
        $this->chargeNotDefault = $chargeNotDefault;
        $this->accountingInvoiceRepository = $accountingInvoiceRepository;
        $this->accountingFailedPaymentsRepository = $accountingFailedPaymentsRepository;
        $this->projectsBandwidthRepo = $projectsBandwidthRepo;
        $this->accountRepository = $accountRepository;
        $this->accountInvoiceRepo = $accountInvoiceRepo;
        $this->diskSpaceRepo = $diskSpaceRepo;
    }

    public function chargeUserImmediately(User $user, PaymentMethod $paymentMethod): bool {
        $objAccounts = $user->userAccounts()->where("flag_status", "past due accounts")->get();

        foreach ($objAccounts as $objAccount) {
            $objTransactions = $objAccount->transactions()->where("transaction_status", "past due accounts")->get();
            $amount = $objTransactions->sum("transaction_amount");

            if ($amount == 0.0) {
                return true;
            }

            $payment = $user->charge($amount * 100, $paymentMethod->id);
            $boolResult = $this->accountInvoiceRepo->storeInvoice([$objTransactions], $amount, $payment);

            if ($boolResult) {
                foreach ($objTransactions as $objTransaction) {
                    $objTransaction->update(["transaction_status" => "paid"]);
                }

                return true;
            } else {
                if (!$boolResult) {
                    throw new \Exception("Something Went Wrong.", 400);
                }
            }
        }

        return (true);
    }

    public function makeCharge(Account $account, ?PaymentMethod $paymentMethod = null): bool {
        try {
            $arrTransactions = $this->prepareCharges($account);
            $amount = $this->calculateAmount($account);

            if ($amount == 0.0) {
                return true;
            }

            [$allMethods, $user] = $this->preparePaymentMethods($account, $paymentMethod);

            foreach ($allMethods as $objMethod) {
                try {
                    $payment = $user->charge($amount * 100, $objMethod->id);
                    $this->accountInvoiceRepo->storeInvoice($arrTransactions, $amount, $payment);

                    foreach ($arrTransactions as $objTransaction) {
                        $objTransaction->update(["transaction_status" => "paid"]);
                    }

                    return true;
                } catch (IncompletePayment $exception) {}
            }

            $status = "past due accounts";
            foreach ($arrTransactions as $objTransaction) {
                $objTransaction->update(["transaction_status" => $status]);
            }
            $account->update(["flag_status" => $status]);

            return false;
        } catch (\Exception $exception) {
            throw new PaymentTaskException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    public function accountPlanCharge(Account $account, AccountTransaction $objTransaction, float $planCost, ?PaymentMethod $paymentMethod = null): bool{
        try {
            if ($planCost == 0.0) {
                return true;
            }

            [$allMethods, $user] = $this->preparePaymentMethods($account, $paymentMethod);

            foreach ($allMethods as $objMethod) {
                try {
                    $payment = $user->charge($planCost * 100, $objMethod->id);
                    $this->accountInvoiceRepo->storeInvoice([$objTransaction], $planCost, $payment);
                    $objTransaction->update(["transaction_status" => "paid"]);

                    return true;
                } catch (IncompletePayment $exception) {}
            }

            $status = "past due accounts";
            $objTransaction->update(["transaction_status" => $status]);
            $account->update(["flag_status" => $status]);

            return false;
        } catch (\Exception $exception) {
            throw new PaymentTaskException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    private function preparePaymentMethods(Account $account, ?PaymentMethod $paymentMethod = null){
        if (is_null($paymentMethod)) {
            $user = $account->user;
            $stripePaymentMethod = $user->defaultPaymentMethod();

            if ($this->chargeNotDefault) {
                $allMethods = $user->paymentMethods();

                $allMethods = $allMethods->sortBy(function ($method) use ($stripePaymentMethod) {
                    if ($method->id == $stripePaymentMethod->id) {
                        return 0;
                    }

                    return 1;
                });
            } else {
                //TODO: Some refactor
                if (is_null($stripePaymentMethod)) {
                    $notDefaultMethods = $user->paymentMethods();

                    if ($notDefaultMethods->isEmpty()) {
                        return false;
                    }

                    $allMethods = [$notDefaultMethods->first()];
                } else {
                    $allMethods = [$stripePaymentMethod];
                }
            }
        } else {
            $allMethods = [$paymentMethod];
            $user = $paymentMethod->owner();
        }

        return ([$allMethods, $user]);
    }

    /**
     * @param Account $account
     * @return array
     */
    private function prepareCharges(Account $account){
        $arrTransactions = [];
        $objAccountPlan = $account->plans()->where("flag_active", true)->orderBy("version", "desc")->first();
        $usersQuantity = $this->accountRepository->accountUsersCountWithoutDeleted($account);
        $additionalUsers = $usersQuantity - $objAccountPlan->planType->plan_users;

        if ($additionalUsers > 0) {
            if ($additionalUsers == 1) {
                $arrTransactions[] = Charge::chargeAccount($objAccountPlan, "user",  $objAccountPlan->planType->plan_user_additional);
            } else {
                $toPayUser = (intval($additionalUsers) - 1) * $objAccountPlan->planType->plan_user_additional;
                $arrTransactions[] = Charge::chargeAccount($objAccountPlan, "user", $toPayUser);
            }
        }

        $dateEnd = Carbon::now()->endOfDay()->toDateTimeString();
        $dateStart = Carbon::now()->subMonth()->startOfDay()->toDateTimeString();

        /* Calculate Transfer Data from Bandwidth */
        $objUsedTransfer = $this->projectsBandwidthRepo->getTransferSizeByAccountAndDates($account, $dateStart, $dateEnd);
        $freeSize = $objAccountPlan->planType->plan_bandwidth;
        $paidSize = ($objUsedTransfer - (intval($freeSize) * 1e+9)) / 1e+9;

        if ($paidSize > 0) {
            $toPayBandwidth = (intval($paidSize) * $objAccountPlan->planType->plan_bandwidth_additional);
            $arrTransactions[] = Charge::chargeAccount($objAccountPlan, "bandwidth", $toPayBandwidth);
        }

        /* Calculate DiskSpace Size */
        $objUsedDiscSpace = $this->diskSpaceRepo->getSumDiskSpaceSize($account->projects()->pluck("project_id")->toArray(), $dateStart, $dateEnd);
        $freeDiscSpaceSize = $objAccountPlan->planType->plan_diskspace;
        $paidDiskSpaceSize = ($objUsedDiscSpace - (intval($freeDiscSpaceSize) * 1e+9)) / 1e+9;

        if ($paidDiskSpaceSize > 0) {
            $toPayDiskSpace = (intval($paidDiskSpaceSize) * $objAccountPlan->planType->plan_diskspace_additional);
            $arrTransactions[] = Charge::chargeAccount($objAccountPlan, "diskspace", $toPayDiskSpace);
        }

        return ($arrTransactions);
    }

    /**
     * @param Account $account
     * @return float
     */
    private function calculateAmount(Account $account): float {
        return ($account->transactions()->where("transaction_status", "!=", "paid")->sum("transaction_amount"));
    }
}
