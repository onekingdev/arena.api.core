<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Accounting\AccountingType;
use Illuminate\Database\Seeder;

class AccountingTypeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run() {
        $arrTypes = [
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Contract",
                "accounting_type_memo" => "Contract Accounting",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "User",
                "accounting_type_memo" => "Monthly User Accounting",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Download",
                "accounting_type_memo" => "Download Accounting",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Deployment",
                "accounting_type_memo" => "Deployment Accounting",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Upload",
                "accounting_type_memo" => "Upload Accounting",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Account.Simple",
                "accounting_type_memo" => "Simple Distribution",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Account.Reporting",
                "accounting_type_memo" => "Blockchain Reporting",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Account.Collaboration",
                "accounting_type_memo" => "Blockchain Collaboration",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Account.Enterprise",
                "accounting_type_memo" => "Blockchain Enterprise",
            ],
            [
                "accounting_type_uuid" => Util::uuid(),
                "accounting_type_name" => "Re-Deployment",
                "accounting_type_memo" => "Re-Deployment Accounting",
            ],
        ];

        foreach ($arrTypes as $arrType) {
            AccountingType::create($arrType);
        }
    }
}
