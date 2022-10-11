<?php

namespace App\Contracts\Soundblock;

use App\Models\Soundblock\Platform as PlatformModel;

interface Platform {
    public function create(array $arrParams);
    public function find($id, ?bool $bnFailure = true);
    public function findAll();
    public function update(PlatformModel $objPlatform, array $arrParams);
}
