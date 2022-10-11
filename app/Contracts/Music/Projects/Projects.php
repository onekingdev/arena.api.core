<?php

namespace App\Contracts\Music\Projects;

use App\Models\Music\Project\Project;
use Illuminate\Http\UploadedFile;

interface Projects {
    public function findAll(?int $perPage = 10, ?array $arrFilters = []);
    public function find($id, bool $bnFailure = false);
    public function getUploadTracksInfo(Project $objProject);
    public function update(Project $objProject, array $arrData);
    public function saveProjectTrack(Project $objProject, UploadedFile $objFile, array $trackInfo);
    public function saveTrackInfo(Project $objProject, array $tracksInfo);

    public function deleteProject(Project $objProject): bool;
}
