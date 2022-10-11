<?php

namespace App\Helpers;

use App\Facades\Cache\AppCache;
use App\Models\Core\Auth\AuthModel;
use App\Models\Core\App;
use Exception;
use Config;

class Client {
    /**
     * @return App|null
     */
    public static function app(): ?App {
        return (Config::get("global.app"));
    }

    public static function platform(): ?string {
        return (Config::get("global.platform"));
    }

    /**
     * @return AuthModel|null
     */
    public static function auth(): ?AuthModel {
        return (Config::get("global.auth"));
    }

    /**
     * @return mixed
     */
    public static function browser() {
        return (Config::get("global.client.browser"));
    }

    /**
     * @param string $apiHost
     * @return void
     * @throws Exception
     */
    public static function checkingAs(string $apiHost = "app.arena.soundblock.web") {
        $_SERVER["HTTP_X_API"] = "v1.0";

        if (!static::validateHostHeader($apiHost)){
            throw new Exception("HTTP_X_API_HOST exception", 400);
        }

        $_SERVER["HTTP_X_API_HOST"] = $apiHost;
    }

    /**
     * @param string $strHeader
     * @return bool
     */
    public static function validateHostHeader(string $strHeader): bool {
        $strCacheAuthKey = self::class . "validateHostHeader.Headers.{$strHeader}.Auth";
        $strCacheAppKey = self::class . "validateHostHeader.Headers.{$strHeader}.App";

        $strHeaderPattern = "/\A(app)\.(arena)\.([a-zA-Z\.]*)\.([android]*[web]*[ios]*)/i";

        if (!preg_match($strHeaderPattern, $strHeader, $arrHeaderInfo)) {
            return (false);
        }

        $strApp = last(explode(".", $arrHeaderInfo[3]));

        $strPlatform = Util::ucfLabel($arrHeaderInfo[4]);

        $strAuthName = "App." . Util::ucfLabel($strApp);

        if (AppCache::isCached($strCacheAuthKey)) {
            $objAuth = AppCache::getCache($strCacheAuthKey);
        } else {
            $objAuth = AuthModel::where("auth_name", $strAuthName)->first();
            AppCache::setCache($objAuth, $strCacheAuthKey);
        }

        if (AppCache::isCached($strCacheAppKey)) {
            $objApp = AppCache::getCache($strCacheAppKey);
        } else {
            $objApp = App::where("app_name", Util::lowerLabel($strApp))->first();
            AppCache::setCache($objApp, $strCacheAppKey);
        }

        if ($objApp) {
            Config::set("global.app", $objApp);
            Config::set("global.platform", $strPlatform);
            Config::set("global.auth", $objAuth);

            return (true);
        } else {
            return (false);
        }
    }

    /**
     * @param string $header
     * @return bool
     */
    public static function validateHeader(string $header): bool {
        if (Util::lowerLabel($header) === "v1.0") {
            return (true);
        } else {
            return (false);
        }
    }
}
