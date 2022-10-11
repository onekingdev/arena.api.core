<?php

namespace App\Http\Transformers\Common;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Notification\Notification as NotificationModel;

class Notification extends BaseTransformer {

    use StampCache;

    public function transform(NotificationModel $objNoti) {
        $response = [
            "notification_uuid"   => $objNoti->notification_uuid,
            "notification_name"   => $objNoti->notification_name,
            "notification_memo"   => $objNoti->notification_memo,
            "notification_action" => $objNoti->notification_action,
            "notification_url"    => $objNoti->notification_url,
            "notification_detail" => $objNoti->pivot ? [
                "notification_state" => $objNoti->pivot->notification_state,
                "flag_canarchive"    => $objNoti->pivot->flag_canarchive,
                "flag_candelete"     => $objNoti->pivot->flag_candelete,
            ] : [],
        ];

        return (array_merge($response, $this->stamp($objNoti)));
    }

    public function includeApp(NotificationModel $objNoti) {
        return ($this->item($objNoti->app, new App));
    }
}
