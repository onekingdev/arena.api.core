<?php

namespace App\Repositories\Soundblock;

use App\Models\Soundblock\Ledger as LedgerModel;
use App\Repositories\BaseRepository;

class Ledger extends BaseRepository {

    /**
     * LedgerRepository constructor.
     * @param LedgerModel $ledger
     */
    public function __construct(LedgerModel $ledger) {
        $this->model = $ledger;
    }

    /**
     * @param string $qldbId
     * @return LedgerModel|null
     */
    public function get(string $qldbId) : ?LedgerModel {
        return $this->model->where("qldb_id", $qldbId)->first();
    }

    public function getRecordsForSync(){
        return ($this->model->whereNull("qldb_id")->get());
    }

    /**
     * @param array $arrData
     * @return LedgerModel
     */
    public function makeModel($arrData = []) {
        return  $this->model->newInstance($arrData);
    }
}
