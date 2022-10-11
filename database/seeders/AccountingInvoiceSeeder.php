<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Accounting\{
    AccountingInvoice,
    AccountingInvoiceType
};
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class AccountingInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $app = App::where("app_name", "soundblock")->first();
        $invoiceType = AccountingInvoiceType::where("type_name", "Soundblock.Project.Contract")->first();

        $users = User::whereIn("user_id", range(1, 7))->get();

        /** @var User $user */
        foreach ($users as $user) {
            /** @var AccountingInvoice $invoice */
            $invoice = $user->userInvoices()->create([
                "invoice_uuid" => Util::uuid(),
                "user_uuid" => $user->user_uuid,
                "app_id" => $app->app_id,
                "app_uuid" => $app->app_uuid,
                "invoice_type" => $invoiceType->type_id,
                "invoice_date" => now(),
                "invoice_amount" => rand(5, 100),
                "invoice_status" => "paid"
            ]);
        }
    }
}
