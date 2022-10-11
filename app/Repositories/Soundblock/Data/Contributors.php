<?php

namespace App\Repositories\Soundblock\Data;

use App\Models\Soundblock\Data\Contributor;
use App\Repositories\BaseRepository;

class Contributors extends BaseRepository {
    /**
     * ProjectsRoles constructor.
     * @param \App\Models\Soundblock\Data\Contributor $model
     */
    public function __construct(Contributor $model) {
        $this->model = $model;
    }
}
