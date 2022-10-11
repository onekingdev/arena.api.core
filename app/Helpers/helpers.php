<?php

use App\Contracts\Core\Notifications\Notifications as NotificationsContract;
use App\Models\Core\App;
use App\Models\Users\User;
use Illuminate\Filesystem\FilesystemAdapter;

if ( !function_exists("cloud_url") ) {
    function cloud_url(string $appName) {
        return app()->make("arena")->cloudUrl($appName);
    }
}

if ( !function_exists("app_url") ) {
    function app_url(string $appName, ?string $default = null) : ?string {
        return app()->make("arena")->appUrl($appName, $default);
    }
}

if ( !function_exists("app_var") ) {
    function app_var(string $appName, string $appVarName, bool $isVersioning = false): ?string {
        return app()->make("arena")->appVar($appName, $appVarName, $isVersioning);
    }
}

if ( !function_exists("bucket_name") ) {
    function bucket_name(string $appName): ?string {
        return app()->make("arena")->s3Bucket($appName);
    }
}

if ( !function_exists("bucket_storage") ) {
    function bucket_storage(string $appName): FilesystemAdapter {
        return app()->make("arena")->s3Storage($appName);
    }
}

if ( !function_exists("is_authorized") ) {
    function is_authorized(User $objUser, string $strGroup, string $strPermission, ?string $app = null, bool $silentException = true, bool $flagStrict = false): bool {
        return app()->make("arena-auth")->isAuthorize($objUser, $strGroup, $strPermission, $app, $silentException, $flagStrict);
    }
}

if ( !function_exists("notify") ) {
    function notify(User $objUser, App $objApp, string $strName, string $strDescription, ?string $strAction = null, ?string $strUrl = null, bool $bnAutoClose = true, int $intCloseIn = NotificationsContract::CLOSE_TIMEOUT) {
        return app()->make("arena-notifications")->notify($objUser, $objApp, $strName, $strDescription, $strAction, $strUrl, $bnAutoClose, $intCloseIn);
    }
}

if ( !function_exists("notify_group") ) {
    function notify_group(string $strGroup, App $objApp, string $strName, string $strDescription, ?string $strAction = null, ?string $strUrl = null, bool $bnAutoClose = true, int $intCloseIn = NotificationsContract::CLOSE_TIMEOUT) {
        return app()->make("arena-notifications")->notifyGroup($strGroup, $objApp, $strName, $strDescription, $strAction, $strUrl, $bnAutoClose, $intCloseIn);
    }
}