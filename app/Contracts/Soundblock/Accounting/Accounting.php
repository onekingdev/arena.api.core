<?php

namespace App\Contracts\Soundblock\Accounting;

use App\Models\Soundblock\Accounts\AccountTransaction;
use App\Models\Users\User;
use Laravel\Cashier\PaymentMethod;
use App\Models\Soundblock\Accounts\Account;

interface Accounting {
    public function makeCharge(Account $account, ?PaymentMethod $paymentMethod = null): bool;

    public function accountPlanCharge(Account $account, AccountTransaction $objTransaction, float $planCost, ?PaymentMethod $paymentMethod = null): bool;

    public function chargeUserImmediately(User $user, PaymentMethod $paymentMethod): bool;
}
