<?php

namespace Database\Seeders;

use App\Facades\Soundblock\Events;
use App\Helpers\Util;
use Illuminate\Database\{Seeder, Eloquent\Model};
use App\Models\Soundblock\{Platform, Projects\Project, Projects\Deployments\Deployment};

class SoundblockDeploySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $arrStatuses = ["pending", "deployed", "failed", "takedown"];

        $countPlatforms = Platform::count();
        $arrDeployStatus = config("constant.soundblock.deployment_status");

        /** @var Project $objProject */
        foreach (Project::all() as $objProject) {
            $projectStatus = $arrDeployStatus[$arrStatuses[rand(0, count($arrStatuses) - 1)]];
            $objDeploy = new Deployment();

            $objDeploy->create([
                "deployment_uuid"   => Util::uuid(),
                "platform_id"       => Platform::find(rand(1, $countPlatforms))->platform_id,
                "platform_uuid"     => Platform::find(rand(1, $countPlatforms))->platform_uuid,
                "deployment_status" => $projectStatus,
                "project_id"        => $objProject->project_id,
                "project_uuid"      => $objProject->project_uuid,
                "collection_id"     => $objProject->collections()->first()->collection_id,
                "collection_uuid"   => $objProject->collections()->first()->collection_uuid,
            ]);

            foreach ($objProject->team->users as $user) {
                Events::create($user, "Deployment: {$projectStatus}", $objProject);
            }
        }

        Model::reguard();
    }
}
