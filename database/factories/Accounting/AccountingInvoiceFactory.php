<?php

namespace Database\Factories\Accounting;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Core\App as AppModel, Users\User as UserModel, Accounting\AccountingInvoice as AccountingInvoiceModel};

class AccountingInvoiceFactory extends Factory {

    protected $model = AccountingInvoiceModel::class;

    public function definition() {
        $objApp = AppModel::first();

        return [
            "invoice_uuid"     => Util::uuid(),
            "app_id"           => $objApp->app_id,
            "app_uuid"         => $objApp->app_uuid,
            "user_id"          => UserModel::factory(),
            "user_uuid"        => function (array $attributes) {
                return UserModel::find($attributes["user_id"])->user_uuid;
            },
            "invoice_type"     => 5,
            "invoice_date"     => now(),
            "invoice_amount"   => 13.00,
            "invoice_status"   => "paid",
            "invoice_coupon"   => null,
            "invoice_discount" => null,
        ];
    }

}
