<?php


namespace App\Facades\Soundblock\Accounting;

use Illuminate\Support\Facades\Facade;
use App\Models\Soundblock\{Accounts\AccountPlan as AccountPlanModel, Accounts\AccountTransaction};

/**
 * @method static AccountTransaction chargeAccount(AccountPlanModel $objAccountPlan, string $type, float $amount)
 */
class Charge extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "charge";
    }
}
