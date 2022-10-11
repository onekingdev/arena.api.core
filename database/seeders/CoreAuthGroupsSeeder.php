<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\{
    Users\User,
    Core\Auth\AuthModel,
    Core\Auth\AuthGroup,
    Core\Auth\AuthPermission,
    BaseModel,
    Core\App
};

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CoreAuthGroupsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run() {
        //
        Model::unguard();

        $authGroups = [
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => null,
                "auth_uuid"  => null,
                "group_name" => "Superuser",
                "group_memo" => "Superuser",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Office")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Office")->firstOrFail()->auth_uuid,
                "group_name" => "App.Office",
                "group_memo" => "Office",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Office")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Office")->firstOrFail()->auth_uuid,
                "group_name" => "App.Office.Support",
                "group_memo" => "Office Support",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Apparel")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Apparel")->firstOrFail()->auth_uuid,
                "group_name" => "App.Apparel.Admin",
                "group_memo" => "Arena Apparel Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Arena")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Arena")->firstOrFail()->auth_uuid,
                "group_name" => "App.Arena.Admin",
                "group_memo" => "Arena: Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Catalog")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Catalog")->firstOrFail()->auth_uuid,
                "group_name" => "App.Catalog.Admin",
                "group_memo" => "Arena Catalog: Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.IO")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.IO")->firstOrFail()->auth_uuid,
                "group_name" => "App.IO.Admin",
                "group_memo" => "Arena IO: Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Merchandising")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Merchandising")->firstOrFail()->auth_uuid,
                "group_name" => "App.Merchandising.Admin",
                "group_memo" => "Arena Merchandising: Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Music")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Music")->firstOrFail()->auth_uuid,
                "group_name" => "App.Music.Admin",
                "group_memo" => "Arena Music: Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Soundblock")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Soundblock")->firstOrFail()->auth_uuid,
                "group_name" => "App.Soundblock.Admin",
                "group_memo" => "Arena Soundblock: Administrator",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Office")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Office")->firstOrFail()->auth_uuid,
                "group_name" => "App.Merchandising.Sales",
                "group_memo" => "Arena Merchandising Sales: Admin",
            ],
            [
                "group_uuid" => Util::uuid(),
                "group_name" => "Arena.Developers",
                "group_memo" => "Arena Developers",
            ],
            [
                "group_uuid" => Util::uuid(),
                "auth_id"    => AuthModel::where("auth_name", "App.Ux")->firstOrFail()->auth_id,
                "auth_uuid"  => AuthModel::where("auth_name", "App.Ux")->firstOrFail()->auth_uuid,
                "group_name" => "App.Ux.Admin",
                "group_memo" => "Arena Ux: Administrator",
            ],
        ];

        foreach ($authGroups as $objAuthGroup) {
            AuthGroup::create($objAuthGroup);
        }

        /**
         * Assign Permissions according to Soundblock to App.Soundblock.Admin Group.
         */

        $objSoundblockAdminGroup = AuthGroup::where("group_name", "App.Soundblock.Admin")->firstOrFail();
        $merchGroup = AuthGroup::where("group_name", "App.Merchandising.Sales")->firstOrFail();
        $arrSoundAuthPermissons = AuthPermission::where("permission_name", "like", "App.Soundblock.%")->get();

        foreach ($arrSoundAuthPermissons as $authPermission) {
            $objSoundblockAdminGroup->permissions()->attach($authPermission->permission_id, [
                "row_uuid"                  => Util::uuid(),
                "group_uuid"                => $objSoundblockAdminGroup->group_uuid,
                "permission_uuid"           => $authPermission->permission_uuid,
                "permission_value"          => 1,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        /**
         * Assign Permissions to App.Office.Admin.
         */

        $objOfficeAdminGroup = AuthGroup::where("group_name", "App.Office")->firstOrFail();

        $arrAuthPermissons = AuthPermission::where("permission_name", "like", "%.Office.Access")->get();

        foreach ($arrAuthPermissons as $authPermission) {
            $objOfficeAdminGroup->permissions()->attach($authPermission->permission_id, [
                "row_uuid"                  => Util::uuid(),
                "group_uuid"                => $objOfficeAdminGroup->group_uuid,
                "permission_uuid"           => $authPermission->permission_uuid,
                "permission_value"          => 1,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        $objApp = App::where("app_name", "office")->firstOrFail();
        /** @var User $objUser */
        foreach (User::find(range(1, 9)) as $objUser) {
            $objUser->groups()->attach($objOfficeAdminGroup->group_id, [
                "row_uuid"                  => Util::uuid(),
                "user_uuid"                 => $objUser->user_uuid,
                "group_uuid"                => $objOfficeAdminGroup->group_uuid,
                "app_id"                    => $objApp->app_id,
                "app_uuid"                  => $objApp->app_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);

            foreach ($arrAuthPermissons as $authPermission) {
                $objUser->permissionsInGroup()->attach($authPermission->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "user_uuid"                 => $objUser->user_uuid,
                    "group_id"                  => $objOfficeAdminGroup->group_id,
                    "group_uuid"                => $objOfficeAdminGroup->group_uuid,
                    "permission_uuid"           => $authPermission->permission_uuid,
                    "permission_value"          => 1,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => 1,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => 1,
                ]);
            }
        }

        $objUxAdminGroup = AuthGroup::where("group_name", "App.Ux.Admin")->firstOrFail();

        $arrUxAuthPermissons = AuthPermission::where("permission_name", "like", "%.Ux.Default")->get();

        foreach ($arrUxAuthPermissons as $authPermission) {
            $objUxAdminGroup->permissions()->attach($authPermission->permission_id, [
                "row_uuid"                  => Util::uuid(),
                "group_uuid"                => $objUxAdminGroup->group_uuid,
                "permission_uuid"           => $authPermission->permission_uuid,
                "permission_value"          => 1,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        $objApp = App::where("app_name", "ux")->firstOrFail();

        foreach (User::find(range(1, 9)) as $objUser) {
            $objUser->groups()->attach($objUxAdminGroup->group_id, [
                "row_uuid"                  => Util::uuid(),
                "user_uuid"                 => $objUser->user_uuid,
                "group_uuid"                => $objUxAdminGroup->group_uuid,
                "app_id"                    => $objApp->app_id,
                "app_uuid"                  => $objApp->app_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);

            foreach ($arrUxAuthPermissons as $authPermission) {
                $objUser->permissionsInGroup()->attach($authPermission->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "user_uuid"                 => $objUser->user_uuid,
                    "group_id"                  => $objUxAdminGroup->group_id,
                    "group_uuid"                => $objUxAdminGroup->group_uuid,
                    "permission_uuid"           => $authPermission->permission_uuid,
                    "permission_value"          => 1,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => 1,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => 1,
                ]);
            }
        }

        foreach ($arrAuthPermissons as $authPermission) {
            $merchGroup->permissions()->attach($authPermission->permission_id, [
                "row_uuid"                  => Util::uuid(),
                "group_uuid"                => $merchGroup->group_uuid,
                "permission_uuid"           => $authPermission->permission_uuid,
                "permission_value"          => 1,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        $merchUsers = User::all();

        foreach ($merchUsers as $user) {
            $merchGroup->users()->attach($user->user_id, [
                "row_uuid"                  => Util::uuid(),
                "user_uuid"                 => $user->user_uuid,
                "group_uuid"                => $merchGroup->group_uuid,
                "app_id"                    => $objApp->app_id,
                "app_uuid"                  => $objApp->app_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);
        }

        $objOfficeSupportGroup = AuthGroup::where("group_name", "App.Office.Support")->firstOrFail();

        $arrSupportAuthPermissions = AuthPermission::where("permission_name", "like", "%.Office.Support.Access.%")
                                                   ->get();

        foreach ($arrSupportAuthPermissions as $authPermission) {
            $objOfficeSupportGroup->permissions()->attach($authPermission->permission_id, [
                "row_uuid"                  => Util::uuid(),
                "group_uuid"                => $objOfficeSupportGroup->group_uuid,
                "permission_uuid"           => $authPermission->permission_uuid,
                "permission_value"          => 1,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        foreach (User::find(range(1, 9)) as $objUser) {
            $objUser->groups()->attach($objOfficeSupportGroup->group_id, [
                "row_uuid"                  => Util::uuid(),
                "user_uuid"                 => $objUser->user_uuid,
                "group_uuid"                => $objOfficeSupportGroup->group_uuid,
                "app_id"                    => $objApp->app_id,
                "app_uuid"                  => $objApp->app_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);

            foreach ($arrSupportAuthPermissions as $authPermission) {
                $objUser->permissionsInGroup()->attach($authPermission->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "user_uuid"                 => $objUser->user_uuid,
                    "group_id"                  => $objOfficeSupportGroup->group_id,
                    "group_uuid"                => $objOfficeSupportGroup->group_uuid,
                    "permission_uuid"           => $authPermission->permission_uuid,
                    "permission_value"          => 1,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => 1,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => 1,
                ]);
            }
        }

        $objDevGroup = AuthGroup::where("group_name", "Arena.Developers")->firstOrFail();
        $arrDevAuthPermissions = AuthPermission::where("permission_name", "like", "Arena.Developers.%")->get();
        $arrUsers = User::find(range(1, 9));

        foreach ($arrUsers as $objUser) {
            $objUser->groups()->attach($objDevGroup->group_id, [
                "row_uuid"                  => Util::uuid(),
                "user_uuid"                 => $objUser->user_uuid,
                "group_uuid"                => $objDevGroup->group_uuid,
                "app_id"                    => $objApp->app_id,
                "app_uuid"                  => $objApp->app_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);

            foreach ($arrDevAuthPermissions as $authPermission) {
                $objUser->permissionsInGroup()->attach($authPermission->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "user_uuid"                 => $objUser->user_uuid,
                    "group_id"                  => $objDevGroup->group_id,
                    "group_uuid"                => $objDevGroup->group_uuid,
                    "permission_uuid"           => $authPermission->permission_uuid,
                    "permission_value"          => 1,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => 1,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => 1,
                ]);
            }
        }

        foreach ($arrDevAuthPermissions as $authPermission) {
            $objDevGroup->permissions()->attach($authPermission->permission_id, [
                "row_uuid"                  => Util::uuid(),
                "group_uuid"                => $objDevGroup->group_uuid,
                "permission_uuid"           => $authPermission->permission_uuid,
                "permission_value"          => 1,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        Model::reguard();
    }
}
