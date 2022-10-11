<?php

namespace App\Repositories\Soundblock;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Collections\CollectionHistory as CollectionHistoryModel;

class CollectionHistory extends BaseRepository {
    public function __construct(CollectionHistoryModel $objHistory) {
        $this->model = $objHistory;
    }
}
