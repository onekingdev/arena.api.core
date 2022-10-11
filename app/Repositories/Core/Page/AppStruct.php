<?php

namespace App\Repositories\Core\Page;


use App\Models\Core\AppsStruct;
use App\Repositories\BaseRepository;

class AppStruct extends BaseRepository {
    public function __construct(AppsStruct $appsStruct) {
        $this->model = $appsStruct;
    }

    public function findByPrefix(string $strPrefix): ?AppsStruct {
        return $this->model->where("struct_prefix", $strPrefix)->first();
    }

    public function findByUuid(string $strUUID): ?AppsStruct {
        return $this->model->where("struct_uuid", $strUUID)->first();
    }
}