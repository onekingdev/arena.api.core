<?php

namespace App\Contracts\Soundblock\Projects;

use App\Models\Common\QueueJob;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Users\User;
use Illuminate\Http\UploadedFile;

interface Project {
    public function create(array $arrParams): ProjectModel;
    public function uploadArtwork(ProjectModel $objProject, $objFile);
    public function findAll(int $perPage = 10, ?string $searchParam = null);
    public function findAllByDeployment(string $deploymentStatus, int $perPage = 10, ?string $searchParam = null);
    public function pingExtractingZip(array $arrParams);
    public function find($project, ?bool $bnFailure = true): ?ProjectModel;
    public function findAllByUser(int $perPage = 10, ?User $objUser = null, string $strSortBy = "last_updated");
    public function findUserProject(string $projectUuid, ?User $objUser = null);
    public function __getAllByDeploymentStatus(...$deploymentStatus);
    public function __getAllByUser(?User $objUser = null);
    public function addFile(array $arrParams): string;
    public function confirm(array $arrParams): QueueJob;
    public function extractCollection(Collection $objCol, UploadedFile $file): QueueJob;
    public function storePayment(ProjectModel $objProject, array $arrParams);
    public function update(ProjectModel $objProject, array $arrParams);
    public function getUsers(string $projectId);
    public function checkUserInProject(string $projectUuid, User $user);
    public function uploadArtworkForDraft($uploadedFile);
}
