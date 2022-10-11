<?php

namespace Database\Factories\Soundblock\Accounts;

use App\Helpers\Util;
use App\Models\Soundblock\Accounts\AccountPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountPlanFactory extends Factory {

    protected $model = AccountPlan::class;

    public function definition() {
        return [
            "plan_uuid"    => Util::uuid(),
            "ledger_id"    => $this->faker->numberBetween(7, 10000),
            "ledger_uuid"  => Util::uuid(),
            "plan_cost"    => 24.99,
            "service_date" => $this->faker->date,
            "plan_type"    => "Smart Block Storage",
        ];
    }

    public function simple() {
        return $this->state(function (array $attributes) {
            return [
                "plan_cost" => 4.99,
                "plan_type" => "Simple Block Storage",
            ];
        });
    }

    public function active() {
        return $this->state(function (array $attributes) {
            return [
                "flag_active" => true,
            ];
        });
    }
}
