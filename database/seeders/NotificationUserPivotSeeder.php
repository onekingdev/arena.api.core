<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\{BaseModel, Users\User, Core\App, Notification\Notification};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class NotificationUserPivotSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $objAppSoundblock = App::where("app_name", "soundblock")->firstOrFail();
        $objAppOffice = App::where("app_name", "office")->firstOrFail();

        $arrNotifications = config("constant.notification.state");
        $arrSoundblockNotifications = Notification::where("app_id", $objAppSoundblock->app_id)->get();
        $arrSoundblockUsers = User::find([1, 2, 3, 4, 5]);

        $arrOfficeNotifications = Notification::where("app_id", $objAppOffice->app_id)->get();
        $arrOfficeUsers = User::find([6, 7, 8, 9]);

        foreach ($arrSoundblockNotifications as $objNotification) {
            foreach ($arrSoundblockUsers as $objUser) {
                $objNotification->users()->attach($objUser->user_id, [
                    "row_uuid"                  => Util::uuid(),
                    "notification_uuid"         => $objNotification->notification_uuid,
                    "user_uuid"                 => $objUser->user_uuid,
                    "notification_state"        => "unread",//$arrNotifications[rand(0, count($arrNotifications) - 1)],
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
                ]);
            }
        }

        foreach ($arrOfficeNotifications as $objNotification) {
            foreach ($arrOfficeUsers as $objUser) {
                $objNotification->users()->attach($objUser->user_id, [
                    "row_uuid"                  => Util::uuid(),
                    "notification_uuid"         => $objNotification->notification_uuid,
                    "user_uuid"                 => $objUser->user_uuid,
                    "notification_state"        => $arrNotifications[rand(0, count($arrNotifications) - 1)],
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
                ]);
            }
        }

        Model::reguard();
    }
}
