<?php

namespace App\Repositories\Accounting;

use Util;
use Exception;
use Carbon\Carbon;
use App\Models\Users\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounting\{AccountingInvoiceTransaction as AccountingInvoiceTransactionModel, AccountingInvoice, AccountingTransactionType};

class AccountingInvoiceTransaction extends BaseRepository {
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @param AccountingInvoiceTransactionModel $model
     * @return void
     */
    public function __construct(AccountingInvoiceTransactionModel $model) {
        $this->model = $model;
    }

    /**
     * @param AccountingInvoice $objInvoice
     * @param Model $instance
     * @param AccountingTransactionType $objTransactionType
     * @param array $arrOptions
     *      $arrOptions = [
     *          'cost'                      => (integer) The integer unit amount in cents of the charge to be applied to the upcomming invoice.
     *          'name'                      => (string) An arbitary string which you can attach to the invoice item.
     *          'quantity'                  => (integer) The quantity of line-item
     *          'transaction_memo'          => (string) optional
     *      ]
     * @return AccountingInvoiceTransactionModel
     * @throws Exception
     *
     */
    public function createTransaction(AccountingInvoice $objInvoice, Model $instance, AccountingTransactionType $objTransactionType, array $arrOptions, User $objOfficeUser): AccountingInvoiceTransactionModel {
        if (!Util::array_keys_exists(["name", "cost", "quantity", "discount"], $arrOptions))
            throw new Exception("Invalid Paramter", 400);

        $cost = ceil(floatval($arrOptions["cost"]) * 100);
        $quantity = intval($arrOptions["quantity"]);
        $discount = intval($arrOptions["discount"]);

        $arrParams = [
            "row_uuid"               => Util::uuid(),
            "invoice_id"             => $objInvoice->invoice_id,
            "invoice_uuid"           => $objInvoice->invoice_uuid,
            "transaction_id"         => $instance->row_id,
            "transaction_uuid"       => $instance->row_uuid,
            "app_field"              => $instance->getKeyName(),
            "transaction_cost"       => $cost,
            "transaction_cost_total" => ceil($cost * (1 - $discount / 100) * $quantity),
            "transaction_name"       => $arrOptions["name"],
            "transaction_quantity"   => $quantity,
            "transaction_memo"       => isset($arrOptions["transaction_memo"]) ? $arrOptions["transaction_memo"] : null,
            "transaction_status"     => isset($arrOptions["transaction_status"]) ? $objInvoice->invoice_status : "pending",
            "transaction_discount"   => $arrOptions["discount"],
            "transaction_type"       => $objTransactionType->type_id,
        ];

        if (($arrOptions["discount"] != 0) && $objOfficeUser) {
            $arrParams = array_merge($arrParams, [
                AccountingInvoiceTransactionModel::DISCOUNT_AT       => Carbon::now(),
                AccountingInvoiceTransactionModel::STAMP_DISCOUNT    => time(),
                AccountingInvoiceTransactionModel::STAMP_DISCOUNT_BY => $objOfficeUser->user_id,
            ]);
        }
        $objTransaction = $instance->accountingInvoiceTransactions()->create($arrParams);

        return ($objTransaction);
    }
}
