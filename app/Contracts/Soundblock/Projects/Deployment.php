<?php

namespace App\Contracts\Soundblock\Projects;


use App\Models\Common\QueueJob;
use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;
use App\Models\Soundblock\Projects\Deployments\DeploymentStatus;
use App\Models\Soundblock\Projects\Project;

interface Deployment {
    public function createMultiple(array $arrParams);
    public function create(Project $project, string $strPlatform): DeploymentModel;
    public function createDeploymentStatus(DeploymentModel $objDeployment);
    public function findAllByProject(string $project, int $perPage = 10, array $option = []);
    public function updateDeploymentStatus(DeploymentStatus $objStatus, DeploymentModel $objDeployment);
    public function zipCollection(string $deployment): QueueJob;
    public function find($id, ?bool $bnFailure = true): DeploymentModel;
    public function findLatest(Project $project): ?DeploymentModel;
    public function download($collection);
    public function update(DeploymentModel $objDeployment, array $arrParams): DeploymentModel;

}
