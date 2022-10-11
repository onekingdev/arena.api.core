<?php

namespace App\Repositories\Apparel;

use App\Models\Apparel\File as FileModel;
use App\Repositories\BaseRepository;

class File extends BaseRepository {
    /**
     * @param FileModel $file
     *
     * @return void
     */
    public function __construct(FileModel $file) {
        $this->model = $file;
    }
}
