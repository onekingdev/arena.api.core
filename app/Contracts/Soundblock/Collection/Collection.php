<?php

namespace App\Contracts\Soundblock\Collection;

use App\Models\Common\QueueJob;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Models\Soundblock\Collections\Collection as SoundblockCollection;

interface Collection {
    public function findAllByProject(string $project, int $perPage = 4, string $type = "soundblock");
    public function getTreeStructure(string $collection);
    public function findOrigin($collection);
    public function find($id, bool $bnFaillure = true);
    public function uploadFile(array $arrParams): string;
    public function addFile(array $arrParams);
    public function create(Project $objProject, array $arrParams): SoundblockCollection;
    public function confirm(array $arrParams): QueueJob;
    public function getTracks($collection);
    public function createFromOld(array $arrParams, ?SoundblockCollection $objCollection = null,
                                  ?EloquentCollection $attachDirs = null, ?EloquentCollection $attachFiles = null);
    public function findLatestByProject(Project $objProject): ?SoundblockCollection;
    public function update(SoundblockCollection $objCollection, array $arrCollection): SoundblockCollection;
    public function attachDirsAndFiles(SoundblockCollection $objNewCollection, SoundblockCollection $objCurCollection,
                                       EloquentCollection $attachDirs = null, EloquentCollection $attachFiles = null,
                                       $default = true): SoundblockCollection;
    public function attachDirsAndFilesToCollection(SoundblockCollection $objCollection,
                                                   ?EloquentCollection $attachDirs = null,
                                                   ?EloquentCollection $attachFiles = null);
    public function editFile(array $arrParams): SoundblockCollection;
    public function getFilesToAdd($existFiles, $arrFiles);
    public function organizeMusics(array $arrParams): SoundblockCollection;
    public function addDirectory($arrParams): SoundblockCollection;
    public function editDirectory(array $arrParams);
    public function getDirsToAdd(EloquentCollection $arrExistDirs, $arrDirs): EloquentCollection;
    public function restore(array $arrParams);
    public function revert(array $arrParams);
    public function deleteFiles(array $arrParams): SoundblockCollection;
    public function zipFiles(string $strCollection, array $arrParam): QueueJob;
    public function deleteDirectory(array $arrParams): SoundblockCollection;
    public function filesHistory(array $arrParams);
    public function findDirectories(SoundblockCollection $objCollection);
    public function getOrderedTracks($collection);
    public function getResources(string $collection, string $path);
    public function getFilesHistory(string $file);
    public function getCollectionFilesHistory(string $collection);
}
