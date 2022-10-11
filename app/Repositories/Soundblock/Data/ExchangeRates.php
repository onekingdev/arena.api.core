<?php

namespace App\Repositories\Soundblock\Data;

use App\Models\Soundblock\Data\ExchangeRate;
use App\Repositories\BaseRepository;

class ExchangeRates extends BaseRepository {
    /**
     * ProjectsRoles constructor.
     * @param \App\Models\Soundblock\Data\ExchangeRate $model
     */
    public function __construct(ExchangeRate $model) {
        $this->model = $model;
    }
}
