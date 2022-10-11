<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Helpers\Util;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Accounts\Account;
use App\Models\{BaseModel, Users\User, Core\Auth\AuthModel, Core\Auth\AuthPermission, Core\Auth\AuthGroup, Core\App};

class ServiceSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $accounts = [
            [
                "account_uuid" => Util::uuid(),
                "user_id"      => User::find(1)->user_id,
                "user_uuid"    => User::find(1)->user_uuid,
                "account_name" => "Swhite@arena",
            ],
            [
                "account_uuid" => Util::uuid(),
                "user_id"      => User::find(2)->user_id,
                "user_uuid"    => User::find(2)->user_uuid,
                "account_name" => "Devans@arena",
            ],
            [
                "account_uuid" => Util::uuid(),
                "user_id"      => User::find(3)->user_id,
                "user_uuid"    => User::find(3)->user_uuid,
                "account_name" => "Mykola@arena",
            ],
            [
                "account_uuid" => Util::uuid(),
                "user_id"      => User::find(4)->user_id,
                "user_uuid"    => User::find(4)->user_uuid,
                "account_name" => "Ajohnson@arena",
            ],
            [
                "account_uuid" => Util::uuid(),
                "user_id"      => User::find(6)->user_id,
                "user_uuid"    => User::find(6)->user_uuid,
                "account_name" => "Mmunir@arena",
            ],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }

        $objAppSoundblock = App::where("app_name", "soundblock")->firstOrFail();

        $arrAccountGroupPerms = Constant::account_level_permissions();

        foreach (Account::all() as $objAccount) {
            $objSoundblockAuthGroup = AuthGroup::create([
                "group_uuid"                => Util::uuid(),
                "auth_id"                   => AuthModel::where("auth_name", "App.Soundblock")->firstOrFail()->auth_id,
                "auth_uuid"                 => AuthModel::where("auth_name", "App.Soundblock")
                                                        ->firstOrFail()->auth_uuid,
                "group_name"                => "App.Soundblock." . "Account." . $objAccount->account_uuid,
                "group_memo"                => "Soundblock:Account Plan:" . $objAccount->account_name,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            //Account Holder
            $objHolder = $objAccount->user;
            $arrUsers = [];

            array_push($arrUsers, $objHolder);
            foreach (User::find(range(1, 7)) as $objUser) {
                if ($objHolder->user_id == $objUser->user_id)
                    continue;
                else
                    array_push($arrUsers, $objUser);
            }

            /** @var User $user */
            foreach ($arrUsers as $user) {
                $user->groups()->attach($objSoundblockAuthGroup->group_id, [
                    "row_uuid"                  => Util::uuid(),
                    "group_uuid"                => $objSoundblockAuthGroup->group_uuid,
                    "user_uuid"                 => $user->user_uuid,
                    "app_id"                    => $objAppSoundblock->app_id,
                    "app_uuid"                  => $objAppSoundblock->app_uuid,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => $user->user_id,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => $user->user_id,
                ]);

                $user->accounts()->attach($objAccount->account_id, [
                    "row_uuid"      => Util::uuid(),
                    "account_uuid"  => $objAccount->account_uuid,
                    "user_uuid"     => $user->user_uuid,
                    "flag_accepted" => true,
                ]);

            }

            foreach ($arrAccountGroupPerms as $objAuthPerm) {
                $objSoundblockAuthGroup->permissions()->attach($objAuthPerm->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "group_uuid"                => $objSoundblockAuthGroup->group_uuid,
                    "permission_uuid"           => $objAuthPerm->permission_uuid,
                    "permission_value"          => 1,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => $objHolder->user_id,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => $objHolder->user_id,
                ]);
            }

            /**
             * Assign group and permissions to the user
             */
            // Assign all permissions to an account holder

            foreach ($arrAccountGroupPerms as $objAuthPerm) {
                foreach ($arrUsers as $user) {
                    $user->groupsWithPermissions()->attach($objSoundblockAuthGroup->group_id,
                        [
                            "row_uuid"                  => Util::uuid(),
                            "user_uuid"                 => $user->user_uuid,
                            "group_uuid"                => $objSoundblockAuthGroup->group_uuid,
                            "permission_id"             => $objAuthPerm->permission_id,
                            "permission_uuid"           => $objAuthPerm->permission_uuid,
                            "permission_value"          => true,
                            BaseModel::STAMP_CREATED    => time(),
                            BaseModel::STAMP_CREATED_BY => $user->user_id,
                            BaseModel::STAMP_UPDATED    => time(),
                            BaseModel::STAMP_UPDATED_BY => $user->user_id,
                        ]);
                }

            }
        }

        Model::reguard();
    }
}
