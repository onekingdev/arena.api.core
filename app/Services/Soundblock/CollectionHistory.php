<?php

namespace App\Services\Soundblock;

use App\Repositories\Soundblock\CollectionHistory as CollectionHistoryRepository;
use App\Models\Soundblock\Collections\CollectionHistory as CollectionHistoryModel;

class CollectionHistory {
    /** @var CollectionHistoryRepository */
    protected CollectionHistoryRepository $colHistoryRepo;

    /**
     * @param CollectionHistoryRepository $colHistoryRepo
     * @return void
     */
    public function __construct(CollectionHistoryRepository $colHistoryRepo) {
        $this->colHistoryRepo = $colHistoryRepo;
    }

    /**
     * @param mixed $history
     * @param bool $bnFailure
     * @return
     * @throws \Exception
     */
    public function find($history, bool $bnFailure = true) {
        return ($this->colHistoryRepo->find($history, $bnFailure));
    }

    /**
     * @param array $arrParams
     * @return CollectionHistoryModel
     */
    public function create(array $arrParams): CollectionHistoryModel {
        $arrHistory = [];

        $arrHistory["collection_id"] = $arrParams["collection_id"];
        $arrHistory["collection_uuid"] = $arrParams["collection_uuid"];
        $arrHistory["history_category"] = $arrParams["history_category"];
        $arrHistory["history_size"] = $arrParams["history_size"];
        $arrHistory["file_action"] = $arrParams["file_action"];
        $arrHistory["history_comment"] = isset($arrParams["history_comment"]) ?
            $arrParams["history_comment"] : $arrParams["history_category"] . "( " . $arrParams["collection_uuid"] . " )";;

        return ($this->colHistoryRepo->create($arrHistory));
    }
}
