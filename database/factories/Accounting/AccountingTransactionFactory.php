<?php

namespace Database\Factories\Accounting;

use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Accounting\AccountingTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountingTransactionFactory extends Factory {
    protected $model = AccountingTransaction::class;

    public function definition() {
        $objApp = App::first();

        return [
            "transaction_uuid"   => Util::uuid(),
            "app_id"             => $objApp->app_id,
            "app_uuid"           => $objApp->app_uuid,
            "transaction_amount" => $this->faker->randomFloat(2, 1.0, 1000.0),
            "transaction_name"   => $this->faker->text(30),
            "transaction_memo"   => $this->faker->text(100),
            "transaction_status" => "not paid",
        ];
    }
}