<?php

namespace App\Http\Transformers\Office\Accounting;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Accounting\AccountingType as AccountingTypeModel;

class AccountingType extends BaseTransformer
{
    use StampCache;

    public function transform(AccountingTypeModel $accountingType) {
        return [
            "accounting_type_uuid" => $accountingType->accounting_type_uuid,
            "accounting_type_name" => $accountingType->accounting_type_name,
            "accounting_type_memo" => $accountingType->accounting_type_memo
        ];
    }

    public function includeAccountingTypeRates(AccountingTypeModel $accountingType) {
        return $this->collection($accountingType->accountingTypeRates, new AccountingTypeRate());
    }

}
