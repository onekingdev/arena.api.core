<?php

namespace App\Services\Core\Notifications;

use App\Models\{Core\App, Users\User};
use App\Events\Common\PrivateNotification;
use App\Contracts\Core\Notifications\Notifications as NotificationsContract;
use App\Services\{Common\App as AppService, Core\Auth\AuthGroup as AuthGroupService};

class Notifications implements NotificationsContract {
    /**
     * @var AuthGroupService
     */
    private AuthGroupService $authGroupService;
    /**
     * @var AppService
     */
    private AppService $appService;

    /**
     * Notifications constructor.
     * @param AuthGroupService $authGroupService
     * @param AppService $appService
     */
    public function __construct(AuthGroupService $authGroupService, AppService $appService) {
        $this->authGroupService = $authGroupService;
        $this->appService = $appService;
    }

    /**
     * @param string $strGroup
     * @param App $objApp
     * @param string $strName
     * @param string $strDescription
     * @param string|null $strAction
     * @param bool $bnAutoClose
     * @param int $intCloseIn
     */
    public function notifyGroup(string $strGroup, App $objApp, string $strName, string $strDescription, ?string $strAction = null, ?string $strUrl = null, bool $bnAutoClose = true, int $intCloseIn = NotificationsContract::CLOSE_TIMEOUT) {
        $objGroup = $this->authGroupService->findByName($strGroup);
        foreach ($objGroup->users as $objUser) {
            if ($objUser instanceof User) {
                $this->notify($objUser, $objApp, $strName, $strDescription, $strAction, $strUrl, $bnAutoClose, $intCloseIn);
            }
        }
    }

    /**
     * @param User $objUser
     * @param App $objApp
     * @param string $strName
     * @param string $strDescription
     * @param string|null $strAction
     * @param bool $bnAutoClose
     * @param int $intCloseIn
     */
    public function notify(User $objUser, App $objApp, string $strName, string $strDescription, ?string $strAction = null, ?string $strUrl = null, bool $bnAutoClose = true, int $intCloseIn = NotificationsContract::CLOSE_TIMEOUT) {
        $arrNotificationInfo = [
            "notification_name" => $strName,
            "notification_memo" => $strDescription,
            "notification_url"  => $strUrl,
            "autoClose"        => $bnAutoClose,
            "showTime"         => $intCloseIn,
        ];

        if (is_string($strAction)) {
            $arrNotificationInfo["notification_action"] = $strAction;
        }

        event(new PrivateNotification($objUser, $arrNotificationInfo, [
            "notification_state" => "unread",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ], $objApp));
    }
}