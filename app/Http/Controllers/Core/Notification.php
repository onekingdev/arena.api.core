<?php

namespace App\Http\Controllers\Core;

use Auth;
use Client;
use Exception;
use App\Http\Controllers\Controller;
use App\Events\Common\PrivateNotification;
use App\Services\Common\Notification as NotificationService;
use App\Http\Requests\Common\Notification\{
    OperateNotifications,
    GetNotifications,
    UpdateSetting
};
use App\Http\Transformers\{Common\Notification as NotificationTransformer};

/**
 * @group Core
 *
 */
class Notification extends Controller {
    /** @var NotificationService */
    private NotificationService $notificationService;

    /**
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    /**
     * @param GetNotifications $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Exception
     */
    public function index(GetNotifications $objRequest) {
        $arrNotifications = $this->notificationService->findAllByUser($objRequest->all());

        return ($this->paginator($arrNotifications, new NotificationTransformer));
    }

    /**
     * @param string $notification
     * @return object
     */
    public function archives(string $notification) {
        if ($this->notificationService->archive([$notification])) {
            return ($this->apiReply("archived"));
        }

        return ($this->apiReject("failed"));
    }

    /**
     * @param OperateNotifications $objRequest
     * @return object
     */
    public function archive(OperateNotifications $objRequest) {
        $archivedCount = $this->notificationService->archive($objRequest->input("notifications"));

        if ($archivedCount) {
            return ($this->apiReply("archived"));
        }

        return ($this->apiReject("failed"));
    }

    /**
     * @param OperateNotifications $objRequest
     * @param NotificationService $notiService
     * @return object
     */
    public function delete(OperateNotifications $objRequest, NotificationService $notiService) {
        $deletedCounts = $notiService->delete($objRequest->input("notifications", null));

        if ($deletedCounts > 0) {
            return ($this->apiReply("{$deletedCounts} notifications deleted."));
        }

        return ($this->apiReject("You Doesn't Have Any Notifications For Delete."));
    }

    /**
     * @param string $notification
     * @param NotificationService $notiService
     * @return object
     * @throws \Exception
     */
    public function read(string $notification, NotificationService $notiService) {
        $objNoti = $notiService->find($notification, true);

        if ($notiService->read($objNoti)) {
            return ($this->apiReply("read"));
        }

        return ($this->apiReject("failed"));
    }

    public function unread(string $notification) {
        $objNotification = $this->notificationService->find($notification);

        if (is_null($objNotification)) {
            return $this->apiReject("Notification Not Found.");
        }

        if ($this->notificationService->unread($objNotification)) {
            return ($this->apiReply("You've Marked This Notification As Unread."));
        }

        return ($this->apiReject("Something Went Wrong."));
    }

    /**
     * @param NotificationService $notiService
     * @return object
     */
    public function showSetting(NotificationService $notiService) {
        $objSetting = $notiService->findSettingByApp(Auth::user(), Client::app());

        return ($this->apiReply($objSetting));
    }

    /**
     * @param UpdateSetting $objRequest
     * @return object
     */
    public function updateSetting(UpdateSetting $objRequest) {
        $objSetting = $this->notificationService->findSettingByApp(Auth::user(), Client::app());

        if (!$objSetting) {
            abort(400, "User has not the notification setting");
        }

        $objSetting = $this->notificationService->updateSetting($objSetting, $objRequest->all());

        return ($this->apiReply($objSetting));
    }

    /**
     * @return object
     */
    public function send() {
        $contents = [
            "notification_name"   => "Test Notification",
            "notification_action" => "",
        ];

        $flags = [
            "notification_state" => "unread",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];
        event(new PrivateNotification(Auth::user(), $contents, $flags, Client::app()));

        return ($this->apiReply());
    }

    public function check() {
        return (view("pusher"));
    }
}
