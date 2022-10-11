<?php

namespace App\Contracts\Core\Notifications;

use App\Models\Core\App;
use App\Models\Users\User;

interface Notifications {
    const CLOSE_TIMEOUT = 5000;

    public function notify(User $objUser, App $objApp, string $strName, string $strDescription, ?string $strAction = null, ?string $strUrl = null, bool $bnAutoClose = true, int $intCloseIn = self::CLOSE_TIMEOUT);
    public function notifyGroup(string $strGroup, App $objApp, string $strName, string $strDescription, ?string $strAction = null, ?string $strUrl = null, bool $bnAutoClose = true, int $intCloseIn = self::CLOSE_TIMEOUT);
}