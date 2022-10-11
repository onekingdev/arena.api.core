<?php

namespace App\Repositories\Soundblock;

use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\TrackHistory as TrackHistoryModel;

class TrackHistory extends BaseRepository {
    /**
     * UpcCodes constructor.
     * @param TrackHistoryModel $model
     */
    public function __construct(TrackHistoryModel $model) {
        $this->model = $model;
    }

    public function findLatestChange(string $track_uuid){
        return ($this->model->where("track_uuid", $track_uuid)->orderBy(BaseModel::STAMP_CREATED, "desc")->first());
    }
}
