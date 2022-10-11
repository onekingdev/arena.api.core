<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\BaseModel;
use App\Models\Users\Accounting\AccountingBanking;
use App\Models\Users\User;
use Faker\Factory;

class UserAccountingBankingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Model::unguard();
        $arrAccTypes = config("constant.soundblock.account_type");
        $faker = Factory::create();

        $bankings = [
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(1)->user_id,
                "user_uuid" => User::find(1)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(1)->user_id,
                "user_uuid" => User::find(1)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => false,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(2)->user_id,
                "user_uuid" => User::find(2)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(2)->user_id,
                "user_uuid" => User::find(2)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => false,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(3)->user_id,
                "user_uuid" => User::find(3)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(4)->user_id,
                "user_uuid" => User::find(4)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(4)->user_id,
                "user_uuid" => User::find(4)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => false,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(5)->user_id,
                "user_uuid" => User::find(5)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(6)->user_id,
                "user_uuid" => User::find(6)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(7)->user_id,
                "user_uuid" => User::find(7)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => $faker->bankRoutingNumber,
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(8)->user_id,
                "user_uuid" => User::find(8)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(9)->user_id,
                "user_uuid" => User::find(9)->user_uuid,
                "bank_name" => $faker->name,
                "account_type" => $arrAccTypes[rand(0, count($arrAccTypes) - 1)],
                "account_number" => $faker->bankAccountNumber,
                "routing_number" => "1234567890",
                "flag_primary" => true,
            ]
        ];

        foreach($bankings as $bank)
        {
            AccountingBanking::create($bank);
        }
        Model::reguard();
    }
}
