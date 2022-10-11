<?php

namespace App\Repositories\Soundblock;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\ProjectNoteAttachment as ProjectNoteAttachmentModel;

class ProjectNoteAttachment extends BaseRepository {
    public function __construct(ProjectNoteAttachmentModel $objAttach) {
        $this->model = $objAttach;
    }
}
