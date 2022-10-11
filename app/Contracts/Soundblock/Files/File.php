<?php

namespace App\Contracts\Soundblock\Files;

use App\Models\Users\User;
use App\Models\Soundblock\Projects\ProjectDraft;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Files\File as FileModel;

interface File {
    public function findWhere(array $arrWhere, $fields = "uuid", string $orderBy = null);
    public function createInCollection(array $arrFile, Collection $objCol, User $objUser = null);
    public function create($arrFile, User $objUser = null): FileModel;
    public function update(FileModel $objFile, array $arrFile): FileModel;
    public function insertMusicRecord($objFile, $arrFile);
    public function insertVideoRecord($objFile, $arrFile);
    public function insertMerchRecord($objFile, $arrFile);
    public function insertOtherRecord($objFile, $arrFile);
    public function createInDraft(array $arrFile, ProjectDraft $objDraft);
    public function updateMusicFile($file, int $intTrackNum);
    public function find($id);
    public function getParam(FileModel $objFile, $bnNew = true): array;
}
