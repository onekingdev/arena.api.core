<?php

namespace Database\Seeders;

use App\Helpers\Constant;
use App\Helpers\Util;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\{Core\App,
    Core\Auth\AuthModel,
    BaseModel,
    Users\User,
    Soundblock\Projects\Project,
    Soundblock\Accounts\Account
};
use Faker\Factory;
use Illuminate\Support\Facades\Storage;

class SoundblockProjectsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();
        $objAppSoundblock = App::where("app_name", "soundblock")->firstOrFail();
        $arrGroupPerms = Constant::project_level_permissions();
        $arrHolderPerms = Constant::user_level_permissions();
        $arrOtherPerms = $arrHolderPerms->random(10);

        $faker = Factory::create();

        $soundblockProjects =
            [
                [//1
                 "project_uuid"  => Util::uuid(),
                 "project_title" => config("seeder.project.1"),
                 "project_type"  => "Album",
                 "account_id"    => Account::find(1)->account_id,
                 "account_uuid"  => Account::find(1)->account_uuid,
                 "project_date"  => Util::now(),
                ],
                [//2
                 "project_uuid"  => Util::uuid(),
                 "project_title" => config("seeder.project.2"),
                 "project_type"  => "Solo",
                 "account_id"    => Account::find(1)->account_id,
                 "account_uuid"  => Account::find(1)->account_uuid,
                 "project_date"  => Util::now(),
                ],
                [//3
                 "project_uuid"  => Util::uuid(),
                 "project_title" => config("seeder.project.3"),
                 "project_type"  => "Album",
                 "account_id"    => Account::find(1)->account_id,
                 "account_uuid"  => Account::find(1)->account_uuid,
                 "project_date"  => Util::now(),
                ],
                [//4
                 "project_uuid"  => Util::uuid(),
                 "project_title" => config("seeder.project.4"),
                 "project_type"  => "EP",
                 "account_id"    => Account::find(2)->account_id,
                 "account_uuid"  => Account::find(2)->account_uuid,
                 "project_date"  => Util::now(),
                ],
                [//5
                 "project_uuid"  => Util::uuid(),
                 "project_title" => "MAGDALENE",
                 "project_type"  => "EP",
                 "account_id"    => Account::find(2)->account_id,
                 "account_uuid"  => Account::find(2)->account_uuid,
                 "project_date"  => Util::now(),
                ],
                [//6
                 "project_uuid"  => Util::uuid(),
                 "project_title" => "Titanic Rising",
                 "project_type"  => "Solo",
                 "account_id"    => Account::find(2)->account_id,
                 "account_uuid"  => Account::find(2)->account_uuid,
                 "project_date"  => Util::now(),
                ],
                [//7
                 "project_uuid"  => Util::uuid(),
                 "project_title" => "Legacy!",
                 "project_type"  => "Album",
                 "account_id"    => Account::find(2)->account_id,
                 "account_uuid"  => Account::find(2)->account_uuid,
                 "project_date"  => Util::now(),
                ],
            ];

        foreach ($soundblockProjects as $project) {
            $objProject = Project::create($project);
            Storage::disk("public")->makeDirectory(Util::project_path($objProject));
            // Storage::disk("public")->putFileAs(Util::project_path($objProject), Storage::disk("public")->path("default/project{$objProject->project_id}.png"), config("constant.soundblock.project_avatar"));
        }

        foreach (Project::all() as $objProject) {
            $objPrjGroup = AuthGroup::create([
                "group_uuid"                => Util::uuid(),
                "auth_id"                   => AuthModel::where("auth_name", "App.Soundblock")->firstOrFail()->auth_id,
                "auth_uuid"                 => AuthModel::where("auth_name", "App.Soundblock")
                                                        ->firstOrFail()->auth_uuid,
                "group_name"                => "App.Soundblock." . "Project." . $objProject->project_uuid,
                "group_memo"                => "App.Soundblock." . "Project.( " . $objProject->project_uuid . " )",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);

            $objHolder = $objProject->account->user;
            $arrUsers = [];

            array_push($arrUsers, $objHolder);

            foreach (User::find(range(1, 8)) as $user) {
                if ($user->user_id == $objHolder->user_id)
                    continue;

                array_push($arrUsers, $user);
            }

            foreach ($arrUsers as $user) {
                $user->groups()->attach($objPrjGroup->group_id, [
                    "row_uuid"                  => Util::uuid(),
                    "group_uuid"                => $objPrjGroup->group_uuid,
                    "user_uuid"                 => $user->user_uuid,
                    "app_id"                    => $objAppSoundblock->app_id,
                    "app_uuid"                  => $objAppSoundblock->app_uuid,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => $user->user_id,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => $user->user_id,
                ]);

            }

            foreach ($arrGroupPerms as $objAuthPerm) {
                $objPrjGroup->permissions()->attach($objAuthPerm->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "group_uuid"                => $objPrjGroup->group_uuid,
                    "permission_uuid"           => $objAuthPerm->permission_uuid,
                    "permission_value"          => 1,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => $objHolder->user_id,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => $objHolder->user_id,
                ]);
            }

            foreach ($arrUsers as $user) {
                if ($user->user_id === $objHolder->user_id) {
                    foreach ($arrHolderPerms as $objAuthPerm) {
                        $objHolder->groupsWithPermissions()->attach($objPrjGroup->group_id,
                            [
                                "row_uuid"                  => Util::uuid(),
                                "user_uuid"                 => $objHolder->user_uuid,
                                "group_uuid"                => $objPrjGroup->group_uuid,
                                "permission_id"             => $objAuthPerm->permission_id,
                                "permission_uuid"           => $objAuthPerm->permission_uuid,
                                BaseModel::STAMP_CREATED    => time(),
                                "permission_value"          => 1,
                                BaseModel::STAMP_CREATED_BY => $objHolder->user_id,
                                BaseModel::STAMP_UPDATED    => time(),
                                BaseModel::STAMP_UPDATED_BY => $objHolder->user_id,
                            ]);
                    }
                } else {
                    foreach ($arrGroupPerms as $objAuthPerm) {
                        if (rand(0, 2) == 0)
                            continue;
                        $user->groupsWithPermissions()->attach($objPrjGroup->group_id,
                            [
                                "row_uuid"                  => Util::uuid(),
                                "user_uuid"                 => $user->user_uuid,
                                "group_uuid"                => $objPrjGroup->group_uuid,
                                "permission_id"             => $objAuthPerm->permission_id,
                                "permission_uuid"           => $objAuthPerm->permission_uuid,
                                "permission_value"          => true,
                                BaseModel::STAMP_CREATED    => time(),
                                BaseModel::STAMP_CREATED_BY => $user->user_id,
                                BaseModel::STAMP_UPDATED    => time(),
                                BaseModel::STAMP_UPDATED_BY => $user->user_id,
                            ]);
                    }

                    foreach ($arrOtherPerms as $objAuthPerm) {
                        $user->groupsWithPermissions()->attach($objPrjGroup->group_id,
                            [
                                "row_uuid"                  => Util::uuid(),
                                "user_uuid"                 => $user->user_uuid,
                                "group_uuid"                => $objPrjGroup->group_uuid,
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
        }

        Model::reguard();
    }
}
