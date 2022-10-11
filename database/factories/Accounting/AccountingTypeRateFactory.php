<?php

namespace Database\Factories\Accounting;

use App\Models\Accounting\AccountingTypeRate;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountingTypeRateFactory extends Factory {

    protected $model = AccountingTypeRate::class;

    public function definition() {
        return [
            "row_uuid"           => $this->faker->uuid,
            "accounting_version" => 1,
            "accounting_rate"    => $this->faker->randomFloat(2),
        ];
    }
}