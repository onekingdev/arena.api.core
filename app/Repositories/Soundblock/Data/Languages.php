<?php

namespace App\Repositories\Soundblock\Data;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Data\Language;

class Languages extends BaseRepository {
    /**
     * ProjectsRoles constructor.
     * @param \App\Models\Soundblock\Data\Language $model
     */
    public function __construct(Language $model) {
        $this->model = $model;
    }

    public function allOrderByName(){
        return ($this->model->orderBy("data_language", "asc")->get());
    }

    public function findAll(array $arrParams, int $perPage){
        $query = $this->model->newQuery();

        if (isset($arrParams["lang_name"])) {
            $query = $query->whereRaw("lower(data_language) like (?)", "%" . Util::lowerLabel($arrParams["lang_name"]) . "%")
                ->orWhere("data_code", "like", "%{$arrParams["lang_name"]}%");
        }

        [$query, $availableFilters] = $this->applyMetaFilters($arrParams, $query);

        return ([$query->paginate($perPage), $availableFilters]);
    }
}
