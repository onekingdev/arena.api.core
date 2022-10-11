<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Accounting\AccountingType;
use App\Models\Accounting\AccountingTypeRate;
use Illuminate\Database\Seeder;

class AccountingTypeRateSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run() {
        $rates = [
            "contract"               => 9.99,
            "user"                   => 1.99,
            "download"               => 0.25,
            "deployment"             => 0.99,
            "re-deployment"          => 1.99,
            "upload"                 => 0.25,
            "account.simple"         => 0,
            "account.reporting"      => 24.99,
            "account.collaboration"  => 249.99,
            "account.enterprise"     => 599.99
        ];

        $arrAllAccounting = AccountingType::all();

        foreach ($arrAllAccounting as $arrAccounting) {
            AccountingTypeRate::create([
                "row_uuid"         => Util::uuid(),
                "accounting_type_id"   => $arrAccounting->accounting_type_id,
                "accounting_type_uuid" => $arrAccounting->accounting_type_uuid,
                "accounting_version"   => 1,
                "accounting_rate"      => $rates[strtolower($arrAccounting->accounting_type_name)],
            ]);
        }
    }
}
