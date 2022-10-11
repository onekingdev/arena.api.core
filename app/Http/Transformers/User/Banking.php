<?php

namespace App\Http\Transformers\User;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Users\Accounting\AccountingBanking;

class Banking extends BaseTransformer
{

    use StampCache;
    public function transform(AccountingBanking $objBanking)
    {
        $response = [
            "bank_uuid" => $objBanking->row_uuid,
            "bank_name" => $objBanking->bank_name,
            "account_type" => $objBanking->account_type,
            "account_number" => $objBanking->account_number,
            "routing_number" => $objBanking->routing_number,
            "flag_primary" => $objBanking->flag_primary,
        ];
        $response = array_merge($response, $this->stamp($objBanking));

        return($response);
    }
}
