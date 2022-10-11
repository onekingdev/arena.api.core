<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\Accounting\AccountingPaypal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Users\User;
use Faker\Factory;

class UserAccountingPaypalSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();
        $faker = Factory::create();

        $paypals = [
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(2)->user_id,
                "user_uuid"    => User::find(2)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(2)->user_id,
                "user_uuid"    => User::find(2)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(3)->user_id,
                "user_uuid"    => User::find(3)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(3)->user_id,
                "user_uuid"    => User::find(3)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(5)->user_id,
                "user_uuid"    => User::find(5)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(5)->user_id,
                "user_uuid"    => User::find(5)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(6)->user_id,
                "user_uuid"    => User::find(6)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(7)->user_id,
                "user_uuid"    => User::find(7)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(8)->user_id,
                "user_uuid"    => User::find(8)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ],
            [
                "row_uuid"     => Util::uuid(),
                "user_id"      => User::find(9)->user_id,
                "user_uuid"    => User::find(9)->user_uuid,
                "paypal"       => $faker->email,
                "flag_primary" => false,
            ]
        ];

        foreach ($paypals as $paypal) {
            AccountingPaypal::create($paypal);
        }

        Model::reguard();
    }
}
