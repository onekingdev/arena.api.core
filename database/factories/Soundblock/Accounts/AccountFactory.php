<?php

namespace Database\Factories\Soundblock\Accounts;

use App\Helpers\Util;
use App\Models\Soundblock\Accounts\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory {
    protected $model = Account::class;

    public function definition() {
        return [
            "account_uuid"       => Util::uuid(),
            "account_name"       => $this->faker->name,
            "flag_status"        => "active",
            "accounting_version" => 1,
        ];
    }
}
