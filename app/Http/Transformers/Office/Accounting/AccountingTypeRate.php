<?php

namespace App\Http\Transformers\Office\Accounting;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Accounting\AccountingTypeRate as AccountingTypeRateModel;

class AccountingTypeRate extends BaseTransformer {
    use StampCache;

    public function transform(AccountingTypeRateModel $accountingTypeRate) {
        return [
            "row_uuid"         => $accountingTypeRate->row_uuid,
            "accounting_type_uuid" => $accountingTypeRate->accounting_type_uuid,
            "accounting_version"   => $accountingTypeRate->accounting_version,
            "accounting_rate"      => $accountingTypeRate->accounting_rate,
        ];
    }
}
