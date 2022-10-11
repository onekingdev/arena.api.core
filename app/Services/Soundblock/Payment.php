<?php

namespace App\Services\Soundblock;

use App\Models\Soundblock\Accounts\Account;
use App\Helpers\Soundblock as SoundblockHelper;
use App\Repositories\Soundblock\ProjectsBandwidth as ProjectsBandwidthRepository;
use App\Repositories\Accounting\AccountingInvoice as AccountingInvoiceRepository;
use App\Repositories\Common\Account as AccountRepository;
use Carbon\Carbon;

class Payment
{
    /** @var ProjectsBandwidthRepository */
    private ProjectsBandwidthRepository $projectsBandwidthRepo;
    /** @var AccountRepository */
    private AccountRepository $accountRepository;
    /** @var AccountingInvoiceRepository */
    private AccountingInvoiceRepository $accountingInvoiceRepo;

    /**
     * Payment constructor.
     * @param ProjectsBandwidthRepository $projectsBandwidthRepo
     * @param AccountRepository $accountRepository
     * @param AccountingInvoiceRepository $accountingInvoiceRepo
     */
    public function __construct(ProjectsBandwidthRepository $projectsBandwidthRepo, AccountRepository $accountRepository,
                                AccountingInvoiceRepository $accountingInvoiceRepo){
        $this->accountRepository = $accountRepository;
        $this->projectsBandwidthRepo = $projectsBandwidthRepo;
        $this->accountingInvoiceRepo = $accountingInvoiceRepo;
    }

    /**
     * @param Account $objAccount
     * @param $uploadFileSize
     * @return bool
     */
    public function calculateBucketStorageFreeSize(Account $objAccount, $uploadFileSize){
        $objAccountPlan = $objAccount->plans()->where("flag_active", true)->orderBy("version", "desc")->first();

        if (in_array($objAccountPlan->planType->plan_level, [1, 4], true)) {
            return (true);
        }

        $objSoundblockHelper = resolve(SoundblockHelper::class);
        $usedSize = $objSoundblockHelper->account_directory_size($objAccount);
        $maxSize = $objAccountPlan->planType->plan_diskspace;

        if ($uploadFileSize > (intval($maxSize) * 1e+9 - intval($usedSize))) {
            return (false);
        }

        return (true);
    }

    /**
     * @param Account $objAccount
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function discReports(Account $objAccount, string $startDate = null, string $endDate = null): array{
        $arrParams = [];
        $today = Carbon::now();
        $planDay = $this->getPlanBillingDay($objAccount);
        $objSoundblockHelper = resolve(SoundblockHelper::class);
        $objAccountPlan = $objAccount->plans()->where("flag_active", true)->orderBy("version", "desc")->first();

        if ($planDay > $today->day) {
            $lastBillingDate = Carbon::now()->subMonth()->setDay($planDay);
        } else {
            $lastBillingDate = Carbon::now()->setDay($planDay);
        }

        if ($startDate && $endDate) {
            $lastBillingDate = Carbon::parse($startDate);
            $today = Carbon::parse($endDate);
        }

        $arrParams["plan_size"] = $objAccountPlan->planType->plan_diskspace;
        $arrParams["plan_transfer"] = $objAccountPlan->planType->plan_bandwidth;
        $arrParams["plan_users"] = $objAccountPlan->planType->plan_users;

        $arrParams["plan_used_size"] = $objSoundblockHelper->account_directory_size($objAccount) / 1e+9;
        $arrParams["plan_used_transfer"] = $this->projectsBandwidthRepo->getTransferSizeByAccountAndDates($objAccount, $lastBillingDate->toDateString(), $today->toDateString())  / 1e+9;
        $arrParams["plan_used_users"] = $this->accountRepository->accountUsersCount($objAccount, $lastBillingDate->toDateString());

        return ($arrParams);
    }

    /**
     * @param Account $objAccount
     * @param string|null $startDate
     * @param string|null $endDate
     * @return mixed
     */
    public function billingReport(Account $objAccount, string $startDate = null, string $endDate = null){
        if (!$startDate || !$endDate) {
            $planDay = $this->getPlanBillingDay($objAccount);

            if ($planDay > Carbon::now()->day) {
                $startDate = Carbon::now()->subMonth()->setDay($planDay);
            } else {
                $startDate = Carbon::now()->setDay($planDay);
            }

            $endDate = Carbon::now();
        }

        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $objInvoices = $this->accountingInvoiceRepo->getInvoicesByUserAndDates(
            $objAccount->user_uuid,
            $startDate->toDateString(),
            $endDate->toDateString()
        );

        return ($objInvoices);
    }

    private function getPlanBillingDay(Account $objAccount){
        $objAccountPlan = $objAccount->plans()->where("flag_active", true)->orderBy("plan_version", "desc")->first();

        return ($objAccountPlan->plan_day);
    }
}
