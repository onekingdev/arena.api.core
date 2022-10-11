<?php

namespace Database\Seeders;

use App\Facades\Soundblock\Events;
use App\Helpers\Util;
use Illuminate\Database\{Seeder, Eloquent\Model};
use App\Models\{Core\Auth\AuthGroup, BaseModel, Soundblock\Projects\Team, Soundblock\Projects\Project};

class SoundblockTeamsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $arrPrjGroups = AuthGroup::where("group_name", "like", "App.Soundblock.Project.%")->get();
        $arrRole = ["Band Member", "Composer", "Lawyer"];
        foreach ($arrPrjGroups as $objGroup) {
            $project = Util::uuid($objGroup->group_name);
            $objProject = Project::where("project_uuid", $project)->firstOrFail();
            $objTeam = new Team();
            $objTeam->create([
                "team_uuid"    => Util::uuid(),
                "project_id"   => $objProject->project_id,
                "project_uuid" => $objProject->project_uuid,
            ]);


        }

        foreach (Team::all() as $objTeam) {
            $count = $objGroup->users->count();
            $objProject = $objTeam->project;
            $objGroup = AuthGroup::where("group_name", "App.Soundblock.Project.$objProject->project_uuid")->firstOrFail();
            foreach ($objGroup->users as $objUser) {
                Events::create($objUser, "Congratulation You are invited to {$objProject->project_title} Project.", $objProject);
                $objUser->teams()->attach($objTeam->team_id,
                    [
                        "row_uuid"                  => Util::uuid(),
                        "team_uuid"                 => $objTeam->team_uuid,
                        "user_uuid"                 => $objUser->user_uuid,
                        "user_role"                 => $arrRole[rand(0, count($arrRole) - 1)],
                        "user_payout"               => 100 / $count,
                        BaseModel::STAMP_CREATED    => time(),
                        BaseModel::STAMP_CREATED_BY => 1,
                        BaseModel::STAMP_UPDATED    => time(),
                        BaseModel::STAMP_UPDATED_BY => 1,
                    ]);
            }
        }

        Model::reguard();
    }
}
