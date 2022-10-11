<?php

namespace App\Http\Transformers\Accounting;

use App\Traits\StampCache;
use App\Services\Auth;
use App\Models\Accounting\AccountingInvoice as AccountingInvoiceModel;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Common\App;

class AccountingInvoice extends BaseTransformer
{
    use StampCache;

    public function transform(AccountingInvoiceModel $objInvoice)
    {
        $response = [
            "invoice_uuid"          => $objInvoice->invoice_uuid,
            "invoice_date"          => $objInvoice->invoice_date,
            "invoice_status"        => $objInvoice->invoice_status,
        ];
        /** @var Auth */
        $authService = resolve(Auth::class);
        $objPayment = $objInvoice->payment()->first();
        if ($objPayment && $authService->checkApp("office")) {
            $response = array_merge($response, [
                "payment" => [
                    "data" => [
                        "payment_response"      => $objPayment->pivot->payment_response,
                        "payment_status"        => $objPayment->pivot->payment_status,
                    ]
                ]
            ]);
        }

        return (array_merge($response, $this->stamp($objInvoice)));
    }

    public function includeApp(AccountingInvoiceModel $objInvoice)
    {
        return ($this->item($objInvoice->app, new App));
    }

    public function includeInvoiceType(AccountingInvoiceModel $objInvoice)
    {
        return ($this->item($objInvoice->invoiceType, new BaseTransformer));
    }
}
