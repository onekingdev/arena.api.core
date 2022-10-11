<?php

namespace App\Http\Transformers\Soundblock;

use App\Http\Transformers\User\User;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Accounts\AccountTransaction;

class Transaction extends BaseTransformer
{

    use StampCache;

    public function transform(AccountTransaction $objTransaction)
    {
        $response = [
            "transaction_uuid"   => $objTransaction->transaction_uuid,
            "ledger_uuid"        => $objTransaction->ledger_uuid,
            "transaction_amount" => $objTransaction->transaction_amount,
            "transaction_type"   => $objTransaction->transaction_type,
            "transaction_status" => $objTransaction->transaction_status,
        ];

        return(array_merge($response, $this->stamp($objTransaction)));
    }

    public function includeUser(AccountTransaction $objTransaction)
    {
        return($this->item($objTransaction->user, new User()));
    }
}

