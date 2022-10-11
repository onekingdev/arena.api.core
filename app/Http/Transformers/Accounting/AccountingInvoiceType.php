<?php

namespace App\Http\Transformers\Accounting;

use App\Http\Transformers\BaseTransformer;
use App\Models\Accounting\AccountingInvoiceType as AccountingInvoiceTypeModel;
use App\Services\Auth;
use App\Traits\StampCache;

class AccountingInvoiceType extends BaseTransformer
{
    use StampCache;

    public function transform(AccountingInvoiceTypeModel $objInvoiceType)
    {
        $response = [
            "type_code"     => $objInvoiceType->type_code
        ];
        /** @var Auth */
        $authService = resolve(Auth::class);
        if ($authService->checkApp("office")) {
            $response = array_merge($response, [
                "type_uuid"     => $objInvoiceType->type_uuid,
                "type_name"     => $objInvoiceType->type_name,
            ]);
        }

        return (array_merge($response, $this->stamp($objInvoiceType)));
    }
}
