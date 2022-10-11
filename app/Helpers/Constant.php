<?php

namespace App\Helpers;

use App\Models\Core\Auth\AuthPermission;
use Illuminate\Support\Collection;

class Constant {
    const __MACOSX = "__MACOSX";
    const MetaFolder = ".meta";

    const MusicExtension = ["wav"];
    const MusicCategory = "music";
    const VideoExtension = ["mp4", "avi", "3gp", "mov"];
    const VideoCategory = "video";
    const MerchExtension = ["ai", "psd"];
    const MerchCategory = "merch";
    const FilesCategory = "files";

    const Separator = "/";

    const NOT_EXIST = 0;
    const EXIST = 1;
    const SOFT_DELETED = 2;

    const ARENA_SOURCE = "ARENA";

    const OFFICE_PERMISSIONS = [
        "App.Office.Access", "App.Office.Support.Access.Apparel", "App.Office.Support.Access.Arena",
        "App.Office.Support.Access.Catalog", "App.Office.Support.Access.IO", "App.Office.Support.Access.Merchandising",
        "App.Office.Support.Access.Music", "App.Office.Support.Access.Office", "App.Office.Support.Access.Soundblock",
        "App.Office.Support.Access.Account", "App.Office.Support.Access.Embroidery", "App.Office.Support.Access.Facecoverings",
        "App.Office.Support.Access.Prints", "App.Office.Support.Access.Screenburning", "App.Office.Support.Access.Sewing",
        "App.Office.Support.Access.Tourmask", "App.Office.Support.Access.Soundblock.Web", "App.Office.Support.Access.Ux",
    ];

    const DEV_PERMISSIONS = [
        "Arena.Developers.Default", "App.Ux.Default",
    ];

    /**
     * @return Collection
     */
    public static function account_level_permissions(): Collection {
        return (AuthPermission::whereIn("permission_name", static::account_level_permission_names())->get());
    }

    /**
     * @return array
     */
    public static function account_level_permission_names(): array {
        return (config("constant.account.permissions"));
    }

    /**
     * @return Collection
     */
    public static function project_level_permissions(): Collection {
        return (AuthPermission::whereIn("permission_name", static::project_level_permission_names())->get());
    }

    /**
     * @return array
     */
    public function user_level_permissions_names(): array {
        return (static::user_level_permissions()->pluck("permission_name")->toArray());
    }

    /**
     * @return Collection
     */
    public static function user_level_permissions(): Collection {
        $projectLevelPermissionNames = static::project_level_permission_names();
        array_push($projectLevelPermissionNames, "App.Office.Admin.Default");
        $projectLevelPermissionNames = array_merge($projectLevelPermissionNames, self::OFFICE_PERMISSIONS,
            self::DEV_PERMISSIONS);

        return (AuthPermission::whereNotIn("permission_name", $projectLevelPermissionNames)->get());
    }

    /**
     * @return array
     */
    public static function project_level_permission_names(): array {
        return (config("constant.soundblock.project.permissions"));
    }
}
