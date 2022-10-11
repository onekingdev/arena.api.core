<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Projects\Deployments\DeploymentStatus as DeploymentStatusModel;

class DeploymentStatus extends BaseTransformer
{

    use StampCache;

    public function transform(DeploymentStatusModel $objStatus)
    {
        $response = [
            "deployment_status" => $objStatus->deployment_status,
            "deployment_memo" => $objStatus->deployment_memo,
        ];

        return (array_merge($response, $this->stamp($objStatus)));
    }
}
