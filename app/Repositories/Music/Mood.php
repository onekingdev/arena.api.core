<?php


namespace App\Repositories\Music;

use Util;
use App\Repositories\BaseRepository;

class Mood extends BaseRepository {
    /**
     * GenreRepository constructor.
     * @param \App\Models\Music\Mood $model
     */
    public function __construct(\App\Models\Music\Mood $model) {
        $this->model = $model;
    }

    public function autocomplete(string $mood) {
        return $this->model->whereRaw("lower(mood_name) like (?)", "%" . Util::lowerLabel($mood) . "%")->get();
    }
}
