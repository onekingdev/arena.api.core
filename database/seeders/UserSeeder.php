<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //$arrUsers = factory(User::class)->times(50)->create();
        Model::unguard();

        $users = [
            [
                //1
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("TurTl3s"),
                "name_first" => "Samuel",
                "name_last" => "White",
                "remember_token" => Str::random(10),
            ],
            [
                //2
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("GoldenRul3$"),
                "name_first" => "Damon",
                "name_last" => "Evans",
                "remember_token" => Str::random(10)
            ],
            [
                //3
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("aqswdefr1"),
                "name_first" => "Mykola",
                "name_last" => "Melnyk",
                "remember_token" => Str::random(10)
            ],
            [
                //4
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("GoldenRul3$"),
                "name_first" => "Adam",
                "name_last" => "Johnson",
                "remember_token" => Str::random(10)
            ],
            [
                //5
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("Chakalacka!123"),
                "name_first" => "Mohsin",
                "name_last" => "Munir",
                "remember_token" => Str::random(10)
            ],
            [
                //6
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("goldenrul3#$"),
                "name_first" => "Shari",
                "name_last" => "Callahan",
                "remember_token" => Str::random(10)
            ],
            [
                //7
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("goldenrul3#$"),
                "name_first" => "Geoff",
                "name_middle" => "Van",
                "name_last" => "Loo",
                "remember_token" => Str::random(10)
            ],
            [
                //8
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("goldenrul3#$"),
                "name_first" => "Brian",
                "name_last" => "Zeman",
                "remember_token" => Str::random(10)
            ],
            [
                //9
                "user_uuid" => Util::uuid(),
                "user_password" => Hash::make("goldenrul3#$"),
                "name_first" => "Seth",
                "name_last" => "Anderson",
                "remember_token" => Str::random(10)
            ]
        ];

        foreach($users as $user)
        {
            User::create($user);

        }

        Model::reguard();
    }
}
