<?php

namespace App\Repositories\Soundblock;

use App\Models\Soundblock\Artist as ArtistModel;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class Artist extends BaseRepository {
    public function __construct(ArtistModel $model) {
        $this->model = $model;
    }

    public function findByName(string $artist) {
        return $this->model->where("artist_name", $artist)->first();
    }

    public function typeahead(array $arrData) {
        $objQuery = $this->model->newQuery();

        if (isset($arrData["artist"])) {
            $objQuery = $objQuery->where("artist_name", "like", "%{$arrData["artist"]}%");
        }

        if (isset($arrData["project"])) {
            $objQuery = $objQuery->whereHas("projects", function (Builder $query) use ($arrData) {
                $query->where("project_uuid", $arrData["project"]);
            });
        }

        if (isset($arrData["account"])) {
            $objQuery = $objQuery->whereHas("projects", function (Builder $query) use ($arrData) {
                $query->where("account_uuid", $arrData["account"]);
            });
        }

        return $objQuery->get();
    }

    /**
     * @param string $account_uuid
     * @return mixed
     */
    public function findAllByAccount(string $account_uuid){
        return ($this->model->where("account_uuid", $account_uuid)->orderBy("artist_name", "asc")->get());
    }

    /**
     * @param string $account_uuid
     * @param string $name
     * @return mixed
     */
    public function findByAccountAndName(string $account_uuid, string $name){
        return ($this->model->where("account_uuid", $account_uuid)->where("artist_name", $name)->first());
    }

    /**
     * @param string $artist
     * @return mixed
     */
    public function delete(string $artist){
        return ($this->model->where("artist_uuid", $artist)->delete());
    }
}
