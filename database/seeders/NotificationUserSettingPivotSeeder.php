<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\{Notification\NotificationSetting, Users\User};
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NotificationUserSettingPivotSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run() {
        //
        Model::unguard();

        $arrNotiSettings = [
            [
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(2)->user_id,
                "user_uuid"    => User::find(2)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(3)->user_id,
                "user_uuid"    => User::find(3)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(5)->user_id,
                "user_uuid"    => User::find(5)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(6)->user_id,
                "user_uuid"    => User::find(6)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(7)->user_id,
                "user_uuid"    => User::find(7)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(8)->user_id,
                "user_uuid"    => User::find(8)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
            [
                "user_id"      => User::find(9)->user_id,
                "user_uuid"    => User::find(9)->user_uuid,
                "user_setting" => config("constant.notification.setting"),
            ],
        ];

        foreach ($arrNotiSettings as $setting) {
            foreach (\App\Models\Core\App::whereIn("app_id", range(1, 8))->get() as $app) {
                $objNoti = new NotificationSetting();

                $objNoti->row_uuid = Util::uuid();
                $objNoti->user_id = $setting["user_id"];
                $objNoti->user_uuid = $setting["user_uuid"];
                $objNoti->app_id = $app->app_id;
                $objNoti->app_uuid = $app->app_uuid;
                $objNoti->user_setting = $setting["user_setting"];
                $objNoti->{"flag_" . $app->app_name} = true;

                $objNoti->save();
            }

        }

        Model::reguard();
    }
}
