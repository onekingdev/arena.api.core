<?php

namespace App\Services\Soundblock\Accounting;

use Util;
use App\Contracts\Soundblock\Accounting\Charge as ChargeContract;
use App\Models\{
    Soundblock\Accounts\AccountTransaction,
    Soundblock\Accounts\AccountPlan as AccountPlanModel
};

class Charge implements ChargeContract {

    /**
     * ChargeAccount constructor.
     */
    public function __construct() {

    }

    public function chargeAccount(AccountPlanModel $objAccountPlan, string $type, float $amount): AccountTransaction{
        $objTransaction = $objAccountPlan->account->transactions()->create([
            "transaction_uuid" => Util::uuid(),
            "account_uuid" => $objAccountPlan->account_uuid,
            "plan_type_id" => $objAccountPlan->plan_type_id,
            "plan_type_uuid" => $objAccountPlan->plan_type_uuid,
            "transaction_amount" => $amount,
            "transaction_type" => $type,
            "transaction_status" => "not paid",
        ]);

        return ($objTransaction);
    }
}
