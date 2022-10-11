<?php

namespace App\Listeners\Common;

use App\Services\Common\Notification;
use App\Models\{Users\User, Core\App};
use App\Events\Common\UserNotification;
use App\Events\Common\PrivateNotification as PrivateNotificationEvent;

class PrivateNotification {
    protected Notification $notificationService;

    /**
     * Create the event listener.
     * @param Notification $notificationService
     * @return void
     */
    public function __construct(Notification $notificationService) {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     *
     * @param PrivateNotificationEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(PrivateNotificationEvent $event) {
        /** @var User */
        $receiver = $event->receiver;
        /** @var array */
        $contents = $event->contents;
        /** @var array */
        $flags = $event->flags;
        /** @var App */
        $app = $event->app;

        $notification = $this->notificationService->create($contents, $receiver, $app);
        $notification = $this->notificationService->attachUser($notification, $receiver, $flags);

        $contents = array_merge($contents, ["notification_uuid" => $notification->notification_uuid]);
        $notificationSetting = $this->notificationService->findSetting($receiver);
        $userSetting = $notificationSetting->where("app_id", $app->app_id)->first();
        $authNames = $this->notificationService->getAllowedApps($userSetting);

        event(new UserNotification($contents, $receiver, $authNames, $notification, ["notification_detail" => [
            "notification_state" => $notification->pivot->notification_state,
            "flag_canarchive"    => $notification->pivot->flag_canarchive,
            "flag_candelete"     => $notification->pivot->flag_candelete,
        ]]));
    }
}
