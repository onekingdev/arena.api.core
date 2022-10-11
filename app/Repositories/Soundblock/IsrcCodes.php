<?php


namespace App\Repositories\Soundblock;


use App\Models\Soundblock\Data\IsrcCode;
use App\Repositories\BaseRepository;

class IsrcCodes extends BaseRepository {
    /**
     * UpcCodes constructor.
     * @param IsrcCode $model
     */
    public function __construct(IsrcCode $model) {
        $this->model = $model;
    }

    public function geUnused() {
        return $this->model->where("flag_assigned", false)->orderBy(\DB::raw("SUBSTR(data_isrc, 11, 5)"))->first();
    }

    public function useIsrc(IsrcCode $objIsrc): IsrcCode {
        $objIsrc->flag_assigned = true;
        $objIsrc->save();

        return $objIsrc;
    }
}