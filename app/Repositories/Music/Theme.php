<?php


namespace App\Repositories\Music;

use Util;
use App\Repositories\BaseRepository;

class Theme extends BaseRepository {
    /**
     * GenreRepository constructor.
     * @param \App\Models\Music\Theme $model
     */
    public function __construct(\App\Models\Music\Theme $model) {
        $this->model = $model;
    }

    public function autocomplete(string $theme) {
        return $this->model->whereRaw("lower(theme_name) like (?)", "%" . Util::lowerLabel($theme) . "%")->get();
    }
}
