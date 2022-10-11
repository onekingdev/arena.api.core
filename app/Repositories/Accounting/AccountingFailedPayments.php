<?php

namespace App\Repositories\Accounting;

use Carbon\Carbon;
use Util;
use Laravel\Cashier\PaymentMethod;
use App\Repositories\BaseRepository;
use App\Models\{Accounting\AccountingFailedPayments as AccountingFailedPaymentsModel, Soundblock\Accounts\Account};

class AccountingFailedPayments extends BaseRepository {
    /**
     * @var AccountingFailedPaymentsModel
     */
    private AccountingFailedPaymentsModel $failedPayments;

    /**
     * FinanceFailedPaymentsRepository constructor.
     * @param AccountingFailedPaymentsModel $failedPayments
     */
    public function __construct(AccountingFailedPaymentsModel $failedPayments) {
        $this->failedPayments = $failedPayments;
    }

    /**
     * @param Account $account
     * @param PaymentMethod $paymentMethod
     * @param float $amount
     * @param string $failReason
     * @throws \Exception
     */
    public function logFailedPayment(Account $account, PaymentMethod $paymentMethod, float $amount, string $failReason) {
        $account->failedPayments()->create([
            "row_uuid"                     => Util::uuid(),
            "account_uuid"                 => $account->account_uuid,
            "fail_reason"                  => $failReason,
            "failed_amount"                => $amount,
            "failed_date"                  => Carbon::now(),
            "failed_stripe_payment_id"     => $paymentMethod->id,
            "failed_stripe_card_brand"     => $paymentMethod->card->brand,
            "failed_stripe_card_last_four" => $paymentMethod->card->last4,
        ]);
    }
}
