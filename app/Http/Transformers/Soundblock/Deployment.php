<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\Platform;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;

class Deployment extends BaseTransformer {

    use StampCache;

    public function transform(DeploymentModel $objDeployment) {
        $response = [
            "deployment_uuid" => $objDeployment->deployment_uuid,
            "ledger_uuid"     => $objDeployment->ledger_uuid,
            "distribution"    => "Everywhere",
        ];

        return (array_merge($response, $this->stamp($objDeployment)));
    }

    public function includePlatform(DeploymentModel $objDeployment) {
        return ($this->item($objDeployment->platform, new Platform()));
    }

    public function includeStatus(DeploymentModel $objDeployment) {
        return ($this->item($objDeployment->status, new DeploymentStatus));
    }

    public function includeProject(DeploymentModel $objDeployment) {
        return ($this->item($objDeployment->project, new Project));
    }

    public function includeCollection(DeploymentModel $objDeployment) {
        return ($this->item($objDeployment->collection, new Collection()));
    }
}
