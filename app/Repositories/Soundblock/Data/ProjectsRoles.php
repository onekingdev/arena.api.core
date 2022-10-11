<?php

namespace App\Repositories\Soundblock\Data;

use App\Models\Soundblock\Data\ProjectsRole;
use App\Repositories\BaseRepository;

class ProjectsRoles extends BaseRepository {
    /**
     * ProjectsRoles constructor.
     * @param \App\Models\Soundblock\Data\ProjectsRole $model
     */
    public function __construct(ProjectsRole $model) {
        $this->model = $model;
    }

    public function findProjectRole(string $strProjectRole) {
        return $this->model->where("data_uuid", $strProjectRole)->first();
    }
}
