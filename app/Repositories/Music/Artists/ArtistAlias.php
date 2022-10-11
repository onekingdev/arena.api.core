<?php

namespace App\Repositories\Music\Artists;

use App\Repositories\BaseRepository;
use App\Models\Music\Artist\ArtistAlias as ArtistAliasModel;

class ArtistAlias extends BaseRepository {
    public function __construct(ArtistAliasModel $model) {
        $this->model = $model;
    }
}