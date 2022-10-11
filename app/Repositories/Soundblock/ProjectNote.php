<?php

namespace App\Repositories\Soundblock;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\ProjectNote as ProjectNoteModel;

class ProjectNote extends BaseRepository {
    public function __construct(ProjectNoteModel $objNote) {
        $this->model = $objNote;
    }
}
