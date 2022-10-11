<?php

namespace App\Contracts\Music\Projects;

use App\Models\Music\Project\Project;
use App\Models\Music\Project\ProjectTrack;

interface Tracks {
    public function show(string $track): ProjectTrack;
    public function store(Project $objProject, array $arrData): ProjectTrack;
    public function uploadProjectTrackFile(string $project, string $track, $file): bool;
    public function update(ProjectTrack $objTrack, array $arrTrackInfo, array $arrTrackMetaData): ProjectTrack;
    public function delete(string $project, string $track): array;
}
