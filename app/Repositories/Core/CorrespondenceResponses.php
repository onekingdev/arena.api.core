<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;
use App\Models\Core\CorrespondenceResponse;

class CorrespondenceResponses extends BaseRepository {
    /**
     * @var CorrespondenceResponse
     * @param CorrespondenceResponse $correspondenceResponse
     */

    /**
     * CorrespondenceAttachmentsRepository constructor.
     * @param CorrespondenceResponse $correspondenceResponse
     */
    public function __construct(CorrespondenceResponse $correspondenceResponse){
        $this->model = $correspondenceResponse;
    }
}
