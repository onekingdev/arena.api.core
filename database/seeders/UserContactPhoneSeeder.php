<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\User;
use App\Models\Users\Contact\UserContactPhone;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserContactPhoneSeeder extends Seeder
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
                $phone = [
                    "row_uuid" => Util::uuid(),
                    "user_id" => $objUser->user_id,
                    "user_uuid" => $objUser->user_uuid,
                    "phone_type" => config("constant.soundblock.phone_type")[rand(0, count(config("constant.soundblock.phone_type")) - 1)],
                    "phone_number" => $faker->phoneNumber,
                    "flag_primary" => false
                ];
                if ($i == 0)
                {
                    $phone["flag_primary"] = true;   
                }
                UserContactPhone::create($phone);
            }
        } 

        Model::reguard();
    }
}
