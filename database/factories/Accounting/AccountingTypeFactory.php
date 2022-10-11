<?php

namespace Database\Factories\Accounting;

use App\Models\Accounting\AccountingType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountingTypeFactory extends Factory {

    protected $model = AccountingType::class;

    public function definition() {
        return [
            "accounting_type_uuid" => $this->faker->uuid,
            "accounting_type_name" => $this->faker->word,
            "accounting_type_memo" => implode(" ", $this->faker->words(2)),
        ];
    }
}
