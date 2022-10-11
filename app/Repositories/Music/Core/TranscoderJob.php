<?php

namespace App\Repositories\Music\Core;

use App\Repositories\BaseRepository;
use App\Models\Music\Core\TranscoderJob as TranscoderJobModel;

class TranscoderJob extends BaseRepository {
    public function __construct(TranscoderJobModel $model) {
        $this->model = $model;
    }

    public function updateStatus(string $strJobId, string $strStatus): TranscoderJobModel {
        /** @var TranscoderJobModel $objJob */
        $objJob = $this->model->where("aws_job_id", $strJobId)->first();

        if (is_null($objJob)) {
            throw new \Exception("Transcoder Job Not Found.");
        }

        $objJob->job_status = strtolower($strStatus);
        $objJob->save();

        return $objJob;
    }
}