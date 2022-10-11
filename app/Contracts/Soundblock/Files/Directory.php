<?php

namespace App\Contracts\Soundblock\Files;


use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Files\Directory as DirectoryModel;

interface Directory {
    public function find($id, bool $bnFailure = true);
    public function findByPath(Collection $objCol, string $path);
    public function findAllByUnderPath(Collection $objCol, string $path);
    public function findAllByPath(Collection $objCol, string $path);
    public function create($arrDirectory, Collection $objCol): DirectoryModel;
    public function update(DirectoryModel $objDirectory, array $arrDirectory): DirectoryModel;
    public function getParam(DirectoryModel $objDir, $bnCreate = true);
}
