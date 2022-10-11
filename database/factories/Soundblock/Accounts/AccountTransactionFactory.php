<?php

namespace Database\Factories\Soundblock\Accounts;

use App\Helpers\Util;
use App\Models\Soundblock\Accounts\AccountTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountTransactionFactory extends Factory {

    protected $model = AccountTransaction::class;

    public function definition() {
        return [
            "row_uuid" => Util::uuid(),
        ];
    }

    public function dummyLedgerData() {
        return $this->state(function (array $attributes) {
            return [
                "ledger_id" => $this->faker->numberBetween(7, 1000000),
                "ledger_uuid" => Util::uuid()
            ];
        });
    }
}
