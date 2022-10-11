<?php

namespace App\Contracts\Soundblock\Accounting;

use App\Models\{
    Soundblock\Accounts\AccountPlan as AccountPlanModel,
    Soundblock\Accounts\AccountTransaction};

interface Charge {
    public function chargeAccount(AccountPlanModel $objAccountPlan, string $type, float $amount): AccountTransaction;
}
