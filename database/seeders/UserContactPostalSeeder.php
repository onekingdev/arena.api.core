<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\User;
use App\Models\Users\Contact\UserContactPostal;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserContactPostalSeeder extends Seeder
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

        foreach(User::all() as $objUser)
        {
            $count = rand(1, 5);
            for($i = 0; $i < $count; $i++)
            {
                $postal = [
                    "row_uuid" => Util::uuid(),
                    "user_id" => $objUser->user_id,
                    "user_uuid" => $objUser->user_uuid,
                    "postal_type" => config("constant.soundblock.postal_type")[rand(0, count(config("constant.soundblock.postal_type")) - 1)],
                    "postal_street" => $faker->streetName,
                    "postal_city" => $faker->city,
                    "postal_zipcode" => $faker->postcode,
                    "postal_country" => $faker->country,
                    "flag_primary" => false
                ];

                if ($i == 0)
                {
                    $postal["flag_primary"] = true;
                }

                UserContactPostal::create($postal);
            }
        }

        Model::reguard();
    }
}
