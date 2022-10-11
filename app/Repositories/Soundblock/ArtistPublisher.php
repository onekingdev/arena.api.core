<?php

namespace App\Repositories\Soundblock;

use App\Models\Soundblock\ArtistPublisher as ArtistPublisherModel;
use App\Repositories\BaseRepository;

class ArtistPublisher extends BaseRepository {
    public function __construct(ArtistPublisherModel $model) {
        $this->model = $model;
    }

    public function findAllByAccount(string $account){
        return ($this->model->where("account_uuid", $account)->orderBy("publisher_name", "asc")->get());
    }

    public function findByAccountAndName(string $account, string $name){
        return ($this->model->where("account_uuid", $account)->where("publisher_name", $name)->first());
    }
}
