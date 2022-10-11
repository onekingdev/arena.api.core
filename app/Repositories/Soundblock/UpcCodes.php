<?php

namespace App\Repositories\Soundblock;

use App\Models\Soundblock\Data\UpcCode;
use App\Repositories\BaseRepository;

class UpcCodes extends BaseRepository {
    /**
     * UpcCodes constructor.
     * @param UpcCode $model
     */
    public function __construct(UpcCode $model) {
        $this->model = $model;
    }

    public function geUnused() {
        return $this->model->where("flag_assigned", false)->orderBy(\DB::raw("SUBSTR(data_upc, 7, 5)"))->first();
    }

    public function useUpc(UpcCode $objUpc) {
        $objUpc->flag_assigned = true;
        $objUpc->save();

        return $objUpc;
    }

    public function freeUpc(UpcCode $objUpc) {
        $objUpc->flag_assigned = false;
        $objUpc->save();

        return $objUpc;
    }

    public function findByUpc(string $strUpc) {
        return $this->model->where("data_upc", $strUpc)->first();
    }
}