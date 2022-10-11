<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\Auth\AuthModel;
use App\Models\Core\Auth\AuthPermission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoreAuthPermissionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        //Soundblock
        $arrSoundPermissions = [
            //Account Permission
            "App.Soundblock.Account.Project.Create", "App.Soundblock.Account.Project.Deploy",
            "App.Soundblock.Account.Report.Audit", "App.Soundblock.Account.Report.Billing",
            "App.Soundblock.Account.Project.Contract", "App.Soundblock.Account.Report.Usage",

            //Project Permission
            "App.Soundblock.Project.Member.Create", "App.Soundblock.Project.Member.Delete", "App.Soundblock.Project.Member.Permissions",
            "App.Soundblock.Project.File.Music.Add", "App.Soundblock.Project.File.Music.Delete", "App.Soundblock.Project.File.Music.Restore",
            "App.Soundblock.Project.File.Music.Update", "App.Soundblock.Project.File.Music.Download", "App.Soundblock.Project.File.Video.Add",
            "App.Soundblock.Project.File.Video.Delete", "App.Soundblock.Project.File.Video.Restore", "App.Soundblock.Project.File.Video.Update",
            "App.Soundblock.Project.File.Video.Download", "App.Soundblock.Project.File.Merch.Add", "App.Soundblock.Project.File.Merch.Delete",
            "App.Soundblock.Project.File.Merch.Restore", "App.Soundblock.Project.File.Merch.Update", "App.Soundblock.Project.File.Merch.Download",
            "App.Soundblock.Project.File.Files.Add", "App.Soundblock.Project.File.Files.Delete", "App.Soundblock.Project.File.Files.Restore",
            "App.Soundblock.Project.File.Files.Update", "App.Soundblock.Project.File.Files.Download", "App.Soundblock.Project.Report.Usage",
        ];

        $arrOfficePermission = ["App.Office.Access"];

        $arrUxPermission = ["App.Ux.Default"];

        $arrDevelopPermission = ["Arena.Developers.Default"];

        $arrOfficeSupportPermission = [
            "App.Office.Support.Access.Apparel", "App.Office.Support.Access.Arena", "App.Office.Support.Access.Catalog",
            "App.Office.Support.Access.IO", "App.Office.Support.Access.Merchandising", "App.Office.Support.Access.Music",
            "App.Office.Support.Access.Office", "App.Office.Support.Access.Soundblock", "App.Office.Support.Access.Account",
            "App.Office.Support.Access.Embroidery", "App.Office.Support.Access.Facecoverings", "App.Office.Support.Access.Prints",
            "App.Office.Support.Access.Screenburning", "App.Office.Support.Access.Sewing", "App.Office.Support.Access.Tourmask",
            "App.Office.Support.Access.Soundblock.Web", "App.Office.Support.Access.Ux",
        ];

        foreach ($arrSoundPermissions as $permission) {

            $authPermission = [
                "permission_uuid" => Util::uuid(),
                "auth_id"         => AuthModel::where("auth_name", "App.Soundblock")->value("auth_id"),
                "auth_uuid"       => AuthModel::where("auth_name", "App.Soundblock")->value("auth_uuid"),
                "permission_name" => $permission,
                "permission_memo" => $permission,
            ];
            AuthPermission::create($authPermission);
        }

        foreach ($arrOfficePermission as $permission) {

            $authPermission = [
                "permission_uuid" => Util::uuid(),
                "auth_id"         => AuthModel::where("auth_name", "App.Office")->value("auth_id"),
                "auth_uuid"       => AuthModel::where("auth_name", "App.Office")->value("auth_uuid"),
                "permission_name" => $permission,
                "permission_memo" => $permission,
            ];
            AuthPermission::create($authPermission);
        }

        foreach ($arrUxPermission as $permission) {

            $authPermission = [
                "permission_uuid" => Util::uuid(),
                "auth_id"         => AuthModel::where("auth_name", "App.Ux")->value("auth_id"),
                "auth_uuid"       => AuthModel::where("auth_name", "App.Ux")->value("auth_uuid"),
                "permission_name" => $permission,
                "permission_memo" => $permission,
            ];
            AuthPermission::create($authPermission);
        }


        foreach ($arrOfficeSupportPermission as $permission) {

            $authPermission = [
                "permission_uuid" => Util::uuid(),
                "auth_id"         => AuthModel::where("auth_name", "App.Office")->value("auth_id"),
                "auth_uuid"       => AuthModel::where("auth_name", "App.Office")->value("auth_uuid"),
                "permission_name" => $permission,
                "permission_memo" => $permission,
            ];
            AuthPermission::create($authPermission);
        }

        foreach ($arrDevelopPermission as $permission) {
            $authPermission = [
                "permission_uuid" => Util::uuid(),
                "auth_id"         => AuthModel::where("auth_name", "App.Office")->value("auth_id"),
                "auth_uuid"       => AuthModel::where("auth_name", "App.Office")->value("auth_uuid"),
                "permission_name" => $permission,
                "permission_memo" => $permission,
            ];

            AuthPermission::create($authPermission);
        }

        Model::reguard();
    }
}
