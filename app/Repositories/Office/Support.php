<?php

namespace App\Repositories\Office;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Support\Support as SupportModel;

class Support extends BaseRepository {
    public function __construct(SupportModel $objSupport) {
        $this->model = $objSupport;
    }

    public function findWhere(array $arrWhere) {
        return ($this->model->where(function ($query) use ($arrWhere) {
            foreach ($arrWhere as $key => $value) {
                if (is_string($value)) {
                    $query->whereRaw("lower($key) = (?)", Util::lowerLabel($value));
                } else {
                    $query->where($key, $value);
                }

            }
        })->firstOrFail());
    }
}
