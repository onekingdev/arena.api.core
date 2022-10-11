<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\Contact\UserContactPostal;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Users\User;

class SoundblockUserAddressSeeder extends Seeder
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

        $faker = Factory::create();
        $arrAddressTypes = config("constant.soundblock.address_type");

        $addresses = [
            [//1
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(1)->user_id,
                "user_uuid" => User::find(1)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//1
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(1)->user_id,
                "user_uuid" => User::find(1)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => false
            ],
            [//2
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(2)->user_id,
                "user_uuid" => User::find(2)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//2
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(3)->user_id,
                "user_uuid" => User::find(3)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//3
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(3)->user_id,
                "user_uuid" => User::find(3)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => false
            ],
            [//3
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(4)->user_id,
                "user_uuid" => User::find(4)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//4
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(4)->user_id,
                "user_uuid" => User::find(4)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => false
            ],
            [//4
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(5)->user_id,
                "user_uuid" => User::find(5)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//5
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(5)->user_id,
                "user_uuid" => User::find(5)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => false
            ],
            [//6
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(6)->user_id,
                "user_uuid" => User::find(6)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//7
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(7)->user_id,
                "user_uuid" => User::find(7)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//8
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(8)->user_id,
                "user_uuid" => User::find(8)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ],
            [//9
                "row_uuid" => Util::uuid(),
                "user_id" => User::find(9)->user_id,
                "user_uuid" => User::find(9)->user_uuid,
                "postal_type" => $arrAddressTypes[rand(0, count($arrAddressTypes) - 1)],
                "postal_street" => $faker->streetName,
                "postal_city" => $faker->city,
                "postal_zipcode" => $faker->postcode,
                "postal_country" => $faker->country,
                "flag_primary" => true
            ]
        ];

        foreach($addresses as $address)
        {
            UserContactPostal::create($address);
        }

        Model::reguard();
    }
}
