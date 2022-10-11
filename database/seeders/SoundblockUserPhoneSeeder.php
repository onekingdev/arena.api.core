<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\Contact\UserContactPhone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Users\User;

class SoundblockUserPhoneSeeder extends Seeder
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

        $arrPhoneTypes = config("constant.soundblock.phone_type");
        $faker = Factory::create();

        $phones = [
            [//1
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(1)->user_id,
                "user_uuid" => User::find(1)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//1
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(1)->user_id,
                "user_uuid" => User::find(1)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//2
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(2)->user_id,
                "user_uuid" => User::find(2)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//2
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(2)->user_id,
                "user_uuid" => User::find(2)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//3
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(3)->user_id,
                "user_uuid" => User::find(3)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//3
                "user_id" => User::find(3)->user_id,
                "user_uuid" => User::find(3)->user_uuid,
                "row_uuid" => Util::uuid(),
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//4
                "user_id" => User::find(4)->user_id,
                "user_uuid" => User::find(4)->user_uuid,
                "row_uuid" => Util::uuid(),
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(4)->user_id,
                "user_uuid" => User::find(4)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//5
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(5)->user_id,
                "user_uuid" => User::find(5)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//5
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(5)->user_id,
                "user_uuid" => User::find(5)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//6
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(6)->user_id,
                "user_uuid" => User::find(6)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//6
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(6)->user_id,
                "user_uuid" => User::find(6)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//7
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(7)->user_id,
                "user_uuid" => User::find(7)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//8
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(8)->user_id,
                "user_uuid" => User::find(8)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ],
            [//9
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(9)->user_id,
                "user_uuid" => User::find(9)->user_uuid,
                "phone_type" => $arrPhoneTypes[rand(0, count($arrPhoneTypes) - 1)],
                "phone_number" => $faker->phoneNumber,
                "flag_primary" => true,
            ]
        ];

        foreach($phones as $phone)
        {
            UserContactPhone::create($phone);
        }

        Model::reguard();
    }
}
