<?php

namespace App\Repositories\Accounting;

use Util;
use Auth;
use Exception;
use App\Models\{
    BaseModel,
    Core\App,
    Users\User,
    Accounting\AccountingInvoice as AccountingInvoiceModel,
    Accounting\AccountingInvoiceType,
    Soundblock\Accounts\Account,
    Soundblock\Accounts\AccountTransaction
};
use Carbon\Carbon;
use Laravel\Cashier\PaymentMethod;
use App\Repositories\BaseRepository;

class AccountingInvoice extends BaseRepository {
    /**
     * AccountingInvoiceRepository constructor.
     * @param AccountingInvoiceModel $accountingInvoice
     */
    public function __construct(AccountingInvoiceModel $accountingInvoice) {
        $this->model = $accountingInvoice;
    }

    /**
     * @param array $options
     * @param int $perPage
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\Paginator
     */
    public function findAll(array $options = [], ?int $perPage = null) {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query = $this->model->with(["invoiceType.app", "transactions.transactionType"])
                             ->leftJoin("core_apps", "accounting_invoices.app_id", "=", "core_apps.app_id")
                             ->leftJoin("accounting_types_invoices", "accounting_invoices.invoice_type", "=", "accounting_types_invoices.type_id");

        $query = $this->applyFilter($query, $options);
        if ($perPage) {
            return ($query->select("accounting_invoices.*")->paginate($perPage));
        } else {
            return ($query->select("accounting_invoices.*")->get());
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyFilter($query, array $options) {
        if (isset($options["sort_invoice_type"])) {
            $query->orderBy("accounting_types_invoices.type_name", Util::lowerLabel($options["sort_invoice_type"]));
        }
        if (isset($options["sort_app"])) {
            $query->orderBy("core_apps.app_name", Util::lowerLabel($options["sort_app"]));
        }

        return ($query);
    }

    /**
     * @param Account $account
     * @param PaymentMethod $paymentMethod
     * @param float $amount
     * @param App $app
     * @param $payment
     * @return AccountingInvoiceModel
     * @throws Exception
     */
    public function storeInvoice(Account $account, float $amount, App $app, $payment): AccountingInvoiceModel {
        $objUser = $account->user;
        $arrPayment = $payment->charges->toArray();

        /** @var AccountingInvoiceModel $invoice */
        $invoice = $this->model->create([
            "invoice_uuid"   => Util::uuid(),
            "app_id"         => $app->app_id,
            "app_uuid"       => $app->app_uuid,
            "user_id"        => $objUser->user_id,
            "user_uuid"      => $objUser->user_uuid,
            "invoice_date"   => Carbon::now(),
            "invoice_amount" => $amount,
            "invoice_status" => "paid",
        ]);

        try {
            foreach ($arrPayment["data"] as $charge){
                $invoice->invoiceActions()->create([
                    "row_uuid" => Util::uuid(),
                    "invoice_uuid" => $invoice->invoice_uuid,
                    "charge_id" => $charge["id"],
                    "response" => $charge,
                    "status" => $charge["status"]
                ]);
            }
        } catch (Exception $e) {
//            throw $e;
        }

        $transactions = $account->transactions;

        /** @var AccountTransaction $transaction */
        foreach ($transactions as $transaction) {
            $invoice->accountTransactions()->attach($transaction->row_id, [
                "row_uuid"         => Util::uuid(),
                "invoice_uuid"     => $invoice->invoice_uuid,
                "app_table" => "soundblock_accounts_transactions",
                "app_field" => "row_id",
                "app_field_id" => $transaction->row_id,
                "transaction_cost" => $transaction->accountingTransaction->transaction_amount,
                "transaction_quantity" => 1,
                "transaction_cost_total" => $transaction->accountingTransaction->transaction_amount,
                "transaction_name" => $transaction->accountingTransaction->transaction_name,
                "transaction_memo" => $transaction->accountingTransaction->transaction_memo,
                "transaction_status" => $transaction->accountingTransaction->transaction_status,
                "transaction_discount" => 0,
                "transaction_type" => $transaction->accountingType->accounting_type_id,
            ]);
        }

        return $invoice;
    }

    /**
     * @param User $objUser
     * @param AccountingInvoiceType $objInvoiceType
     * @param App $objApp
     * @param array $arrOptions
     * @return AccountingInvoiceModel
     * @throws Exception
     */
    public function createInvoiceFor(User $objUser, AccountingInvoiceType $objInvoiceType, App $objApp, array $arrOptions = []): AccountingInvoiceModel {
        if (!array_key_exists("payment_response", $arrOptions) || !$objUser->stripe)
            throw new Exception("Invalid Parameter.", 400);
        $model = $this->model->newInstance();

        $arrParams = [
            "invoice_uuid"     => Util::uuid(),
            "app_id"           => $objApp->app_id,
            "app_uuid"         => $objApp->app_uuid,
            "user_id"          => $objUser->user_id,
            "user_uuid"        => $objUser->user_uuid,
            "invoice_type"     => $objInvoiceType->type_id,
            "invoice_date"     => Carbon::now(),
            "invoice_amount"   => $arrOptions["payment_response"]["total"],
            "invoice_status"   => $arrOptions["payment_response"]["status"],
            "invoice_discount" => isset($arrOptions["discount"]) ? intval($arrOptions["discount"]) : null,
            "invoice_coupon"   => isset($arrOptions["coupon"]) ? $arrOptions["coupon"] : null,
        ];

        if (isset($arrOptions["discount"])) {
            $arrParams = array_merge($arrParams, [
                BaseModel::DISCOUNT_AT       => now(),
                BaseModel::STAMP_DISCOUNT    => time(),
                BaseModel::STAMP_DISCOUNT_BY => Auth::id(),
            ]);
        }
        $model = $model->create($arrParams);

        $model->payment()->attach($objUser->stripe->row_id, [
            "row_uuid"                  => Util::uuid(),
            "payment_uuid"              => $objUser->stripe->row_uuid,
            "invoice_uuid"              => $model->invoice_uuid,
            "payment_response"          => $arrOptions["payment_response"],
            "payment_status"            => $arrOptions["payment_response"]["status"],
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_CREATED_BY => Auth::id(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_UPDATED_BY => Auth::id(),
        ]);

        return ($model);
    }

    /**
     * @param string $strUserUUID
     * @param int $perPage
     * @return mixed
     */
    public function getUserInvoices(string $strUserUUID, int $perPage) {
        $objInvoices = $this->model->where("user_uuid", $strUserUUID)->paginate($perPage);

        return ($objInvoices);
    }

    public function getInvoiceByUuid(string $strInvoiceUUID) {
        $objInvoice = $this->model->where("invoice_uuid", $strInvoiceUUID)->first();

        return ($objInvoice);
    }

    public function getInvoicesByUserAndDates(string $user, string $startDate, string $endDate){
        return ($this->model->where("user_uuid", $user)->whereBetween(BaseModel::CREATED_AT, [$startDate, $endDate])->get());
    }
}
