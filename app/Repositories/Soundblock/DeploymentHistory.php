<?php

namespace App\Repositories\Soundblock;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\Deployments\DeploymentHistory as DeploymentHistoryModel;

class DeploymentHistory extends BaseRepository {
    public function __construct(DeploymentHistoryModel $objDeployment) {
        $this->model = $objDeployment;
    }
}
