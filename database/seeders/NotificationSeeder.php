<?php

namespace Database\Seeders;

use App\Helpers\Builder;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Notification\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder {
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

        $notifications = [
            [//1
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Remind me Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//2
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Happy Camp Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//3
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Verification Required",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//1
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Our Shining days Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//2
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Rising Talent Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//3
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Verification Required",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//1
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Wet Floor Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//2
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to You are my happiness Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//3
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppSoundblock->app_id,
                "app_uuid"            => $objAppSoundblock->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Miss her Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//4
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppOffice->app_id,
                "app_uuid"            => $objAppOffice->app_uuid,
                "notification_name"   => "Office",
                "notification_memo"   => "Congratulation You are invited to  All Mirrors Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//5
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppOffice->app_id,
                "app_uuid"            => $objAppOffice->app_uuid,
                "notification_name"   => "Office",
                "notification_memo"   => "Congratulation You are invited to  MAGDALENE Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//6
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppOffice->app_id,
                "app_uuid"            => $objAppOffice->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to Titanic Rising Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
            [//7
                "notification_uuid"   => Util::uuid(),
                "app_id"              => $objAppOffice->app_id,
                "app_uuid"            => $objAppOffice->app_uuid,
                "notification_name"   => "Soundblock",
                "notification_memo"   => "Congratulation You are invited to  Legacy! Project.",
                "notification_action" => Builder::notification_button("accept", "reject"),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        Model::reguard();
    }
}
