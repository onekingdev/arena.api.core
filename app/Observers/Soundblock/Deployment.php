<?php

namespace App\Observers\Soundblock;

use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;

class Deployment
{
    public function updated(DeploymentModel $objDeployment){
        $objDeployment->update([
            "flag_notify_admin" => false,
            "flag_notify_user" => false,
        ]);
    }
}
