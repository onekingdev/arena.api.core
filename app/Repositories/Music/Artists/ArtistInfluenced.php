<?php

namespace App\Repositories\Music\Artists;

use App\Repositories\BaseRepository;
use App\Models\Music\Artist\ArtistInfluenced as ArtistInfluencedModel;

class ArtistInfluenced extends BaseRepository {
    /**
     * ArtistInfluenced constructor.
     * @param ArtistInfluencedModel $model
     */
    public function __construct(ArtistInfluencedModel $model) {
        $this->model = $model;
    }
}