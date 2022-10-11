<?php

namespace App\Repositories\Soundblock\Data;

use App\Models\Soundblock\Data\Genre;
use App\Repositories\BaseRepository;

class Genres extends BaseRepository {
    /**
     * ProjectsRoles constructor.
     * @param \App\Models\Soundblock\Data\Genre $model
     */
    public function __construct(Genre $model) {
        $this->model = $model;
    }

    public function findAll(array $arrParams){
        $query = $this->model->newQuery();

        if (isset($arrParams["flag_primary"])) {
            $query = $query->where("flag_primary", $arrParams["flag_primary"]);
        }

        if (isset($arrParams["flag_secondary"])) {
            $query = $query->where("flag_secondary", $arrParams["flag_secondary"]);
        }

        return ($query->get());
    }

    public function findByUuid(string $genre, bool $flag_primary = false, bool $flag_secondary = false){
        return (
            $this->model->where("flag_primary", $flag_primary)
                ->where("flag_secondary", $flag_secondary)
                ->where("data_uuid", $genre)
                ->first()
        );
    }
}
