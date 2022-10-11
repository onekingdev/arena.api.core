<?php

namespace App\Repositories\Soundblock;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\{Files\FileHistory as FileHistoryModel, Files\File};

class FileHistory extends BaseRepository {

    public function __construct(FileHistoryModel $objHistory) {
        $this->model = $objHistory;
    }

    /**
     * @param File $objParent
     * @return File
     */
    public function findChild(File $objParent): ?File {
        $objChildFile = null;

        $child = $this->model->where("file_id", $objParent->file_id)->orderBy("collection_id", "asc")->firstOrFail();
        while ($child) {
            $child = $this->model->where("parent_id", $child->file_id)->orderBy("collection_id", "asc")->first();
            if ($child && $child->file)
                $objChildFile = $child->file;
        }

        return ($objChildFile);
    }

    /**
     * @param File $objFile
     *
     * @return FileHistoryModel
     */
    public function getLatestHistoryByFile(File $objFile) {
        return ($this->model->where("file_id", $objFile->file_id)->orderBy("collection_id", "desc")->first());
    }
}
