<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\BaseModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Projects\Deployments\Deployment;
use App\Models\Soundblock\Projects\Deployments\DeploymentStatus;

class SoundblockDeploymentStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        foreach (Deployment::all() as $objDeployment) {
            DeploymentStatus::create([
                "row_uuid"                  => Util::uuid(),
                "deployment_id"             => $objDeployment->deployment_id,
                "deployment_uuid"           => $objDeployment->deployment_uuid,
                "deployment_status"         => $objDeployment->deployment_status,
                "deployment_memo"           => "deployment_memo",
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => 1,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => 1,
            ]);
        }

        Model::reguard();
    }
}
