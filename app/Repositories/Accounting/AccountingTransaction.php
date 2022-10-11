<?php


namespace App\Repositories\Accounting;

use Util;
use App\Repositories\BaseRepository;
use App\Models\{
    Core\App,
    Accounting\AccountingTypeRate,
    Accounting\AccountingTransaction as AccountingTransactionModel,
    Soundblock\Accounts\AccountTransaction
};

class AccountingTransaction extends BaseRepository {
    /**
     * AccountingTransaction constructor.
     * @param AccountingTransactionModel $accountingTransaction
     */
    public function __construct(AccountingTransactionModel $accountingTransaction) {
        $this->model = $accountingTransaction;
    }

    public function createAccountingTransaction(AccountTransaction $accountTransaction, AccountingTypeRate $accountingTypeRate,
                                                App $app, ?float $customRate = null, string $strCustomStatus = "not paid",
                                                ?string $chargeName = null) {
        return $accountTransaction->accountingTransaction()->create([
            "transaction_uuid"     => Util::uuid(),
            "app_id"               => $app->app_id,
            "app_uuid"             => $app->app_uuid,
            "app_table"            => $accountTransaction->getTable(),
            "app_field"            => $accountTransaction->getKeyName(),
            "app_field_id"         => $accountTransaction->row_id,
            "app_field_uuid"       => $accountTransaction->row_uuid,
            "transaction_amount"   => $customRate ?? $accountingTypeRate->accounting_rate,
            "transaction_name"     => is_null($chargeName) ? ucfirst($app->app_name) . " Transaction" : $chargeName,
            "transaction_memo"     => is_null($chargeName) ? ucfirst($app->app_name) . " Transaction" : $chargeName,
            "transaction_status"   => $strCustomStatus,
            "accounting_type_id"   => $accountingTypeRate->accounting_type_id,
            "accounting_type_uuid" => $accountingTypeRate->accounting_type_uuid,
        ]);
    }
}
