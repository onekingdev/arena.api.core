<?php

namespace App\Repositories\Soundblock;

use Util;
use Carbon\Carbon;
use App\Repositories\BaseRepository;
use App\Models\{BaseModel,
    Soundblock\Accounts\AccountInvoice as AccountInvoiceModel,};

class AccountInvoice extends BaseRepository {
    /**
     * AccountTransactionRepository constructor.
     * @param AccountInvoiceModel $accountInvoice
     */
    public function __construct(AccountInvoiceModel $accountInvoice) {
        $this->model = $accountInvoice;
    }

    public function storeInvoice(array $arrAccountTransaction, float $amount, $payment){
        $arrPayment = $payment->charges->toArray();
        $arrInsert = [
            "invoice_uuid"   => Util::uuid(),
            "invoice_date"   => Carbon::now()->toDateTimeString(),
            "invoice_amount" => $amount,
        ];

        $arrInsert["charge_id"] = $arrPayment["data"][0]["id"];
        $arrInsert["response"] = $arrPayment["data"][0];
        $arrInsert["invoice_status"] = $arrPayment["data"][0]["status"];

        $objInvoice = $this->model->create($arrInsert);

        foreach ($arrAccountTransaction as $objTransaction) {
            $objInvoice->transactions()->attach($objTransaction->transaction_id, [
                "row_uuid" => Util::uuid(),
                "invoice_uuid" => $objInvoice->invoice_uuid,
                "transaction_uuid" => $objTransaction->transaction_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_UPDATED    => time(),
            ]);
        }
    }
}
