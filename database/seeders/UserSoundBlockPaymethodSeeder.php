<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Illuminate\Database\Seeder;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Soundblock\Users\UsersPaymethods;
use Illuminate\Database\Eloquent\Model;

class UserSoundBlockPaymethodSeeder extends Seeder
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

        $swhiteEmail = "swhite@arena.com";
        $jinEmail = "vkarpenko@arena.com";

        $paymethods = [
            [
                "row_uuid" => Util::uuid(),
                "user_id" => UserContactEmail::where("user_auth_email", $swhiteEmail)->first()->user->user_id,
                "user_uuid" => UserContactEmail::where("user_auth_email", $swhiteEmail)->first()->user->user_uuid,
                "user_paypal" => "swhite@pay.com",
                "user_bankname" => "BANK1",
                "user_bankaccount" => "12345678243434234234",
                "user_bankroute" => "123456789",
                "flag_simpleblock" => false,
                "flag_smartblock" => true,
            ],
            [
                "row_uuid" => Util::uuid(),
                "user_id" => UserContactEmail::where("user_auth_email", $jinEmail)->first()->user->user_id,
                "user_uuid" => UserContactEmail::where("user_auth_email", $jinEmail)->first()->user->user_uuid,
                "user_paypal" => "vkarpenko@pay.com",
                "user_bankname" => "BANK2",
                "user_bankaccount" => "12345678243434234234",
                "user_bankroute" => "123456789",
                "flag_simpleblock" => false,
                "flag_smartblock" => true,
            ],
        ];
        foreach($paymethods as $paymethod)
        {
            UsersPaymethods::create($paymethod);
        }

        Model::reguard();

    }
}
