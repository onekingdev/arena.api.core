<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Users\User;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Support\Carbon;

class UsersEmailsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $usersEmails = [
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(1)->user_id,
                "user_uuid"                      => User::find(1)->user_uuid,
                "user_auth_email"                => "swhite@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 1,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(2)->user_id,
                "user_uuid"                      => User::find(2)->user_uuid,
                "user_auth_email"                => "devans@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 1,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(3)->user_id,
                "user_uuid"                      => User::find(3)->user_uuid,
                "user_auth_email"                => "melnyk@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 2,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(4)->user_id,
                "user_uuid"                      => User::find(4)->user_uuid,
                "user_auth_email"                => "ajohnson@soundblock.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 4,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(5)->user_id,
                "user_uuid"                      => User::find(5)->user_uuid,
                "user_auth_email"                => "mmunir@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 4,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(6)->user_id,
                "user_uuid"                      => User::find(6)->user_uuid,
                "user_auth_email"                => "scallahan@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 4,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(7)->user_id,
                "user_uuid"                      => User::find(7)->user_uuid,
                "user_auth_email"                => "gvanloo@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 4,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(8)->user_id,
                "user_uuid"                      => User::find(8)->user_uuid,
                "user_auth_email"                => "bzeman@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 5,
            ],
            [
                "row_uuid"                       => Util::uuid(),
                "user_id"                        => User::find(9)->user_id,
                "user_uuid"                      => User::find(9)->user_uuid,
                "user_auth_email"                => "sanderson@arena.com",
                "flag_primary"                   => true,
                "flag_verified"                  => true,
                UserContactEmail::EMAIL_AT       => Util::now(),
                UserContactEmail::STAMP_EMAIL    => time(),
                UserContactEmail::STAMP_EMAIL_BY => 5,
            ]
        ];

        foreach ($usersEmails as $userEmail) {
            UserContactEmail::create($userEmail);
        }

        Model::reguard();
    }
}
