<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\Account;
use App\Http\Transformers\BaseTransformer;
use App\Models\{
    Users\User,
    Soundblock\Accounts\AccountPlan as AccountPlanModel
};

class AccountPlan extends BaseTransformer {
    use StampCache;

    public function transform(?AccountPlanModel $objPlan) {
        if (is_null($objPlan)) {
            return null;
        }

        $response = [
            "plan_uuid"    => $objPlan->plan_uuid,
            "ledger_uuid"  => $objPlan->ledger_uuid,
            "plan_type"    => $objPlan->planType->plan_name,
            "plan_cost"    => $objPlan->planType->plan_rate,
            "service_date" => $objPlan->service_date,
            "flag_active"  => $objPlan->flag_active,
        ];
        /** @var User */
        $objUser = $objPlan->account->user;
        if ($objUser->stripe) {
            $response = array_merge($response, ["payment" => encrypt($objUser->stripe->row_uuid)]);
        }
        return (array_merge($response, $this->stamp($objPlan)));
    }

    public function includeAccount(AccountPlanModel $objPlan) {
        if ($objPlan->account)
            return ($this->item($objPlan->account, new Account));
    }
}
