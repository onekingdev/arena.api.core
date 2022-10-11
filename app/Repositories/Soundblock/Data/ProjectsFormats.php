<?php

namespace App\Repositories\Soundblock\Data;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Data\ProjectsFormat;

class ProjectsFormats extends BaseRepository {
    /**
     * ProjectsFormats constructor.
     * @param \App\Models\Soundblock\Data\ProjectsFormat $model
     */
    public function __construct(ProjectsFormat $model) {
        $this->model = $model;
    }

    public function findProjectFormat(string $strProjectFormat) {
        return $this->model->where("data_uuid", $strProjectFormat)->first();
    }
}
