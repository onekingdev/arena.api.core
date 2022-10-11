<?php

namespace App\Contracts\Soundblock\Collection;


use App\Models\Soundblock\Collections\CollectionHistory as CollectionHistoryModel;

interface CollectionHistory {
    public function find($history, bool $bnFailure = true);
    public function create(array $arrParams): CollectionHistoryModel;
}
