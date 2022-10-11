<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;
use App\Models\Core\CorrespondenceAttachment;

class CorrespondenceAttachments extends BaseRepository {
    /**
     * @var CorrespondenceAttachment
     * @param CorrespondenceAttachment $correspondenceAttachment
     */

    /**
     * CorrespondenceAttachmentsRepository constructor.
     * @param CorrespondenceAttachment $correspondenceAttachment
     */
    public function __construct(CorrespondenceAttachment $correspondenceAttachment){
        $this->model = $correspondenceAttachment;
    }
}
