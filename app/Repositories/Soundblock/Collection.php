<?php

namespace App\Repositories\Soundblock;

use Util;
use Auth;
use App\Repositories\BaseRepository;
use App\Models\{BaseModel, Users\User};
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use App\Models\Soundblock\{Collections\Collection as CollectionModel, Files\File, Projects\Project};

class Collection extends BaseRepository {

    public function __construct(CollectionModel $objCol) {
        $this->model = $objCol;
    }

    public function findAllByProject(Project $objProject, string $type = "soundblock", ?int $perPage = null, $changedEntity = null) {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $queryBuilder = $objProject->collections();

        if ($type == "soundblock") {
            $queryBuilder->with(["history"])->withCount("collectionFilesHistory")->orderBy("collection_id", "desc");
        }

        $queryBuilder->where(function ($query) use ($changedEntity){
            if (is_array($changedEntity)) {
                foreach ($changedEntity as $strCategory) {
                    $this->applyFilterCategory($strCategory, $query);
                }
            } elseif (is_string($changedEntity)) {
                $this->applyFilterCategory($changedEntity, $query);
            }
        });

        if ($perPage) {
            $arrCollections = $queryBuilder->paginate($perPage);
        } else {
            $arrCollections = $queryBuilder->get();
        }
        return ($arrCollections);
    }

    /**
     * @param Project $objProject
     * @return CollectionModel
     */
    public function findLatestByProject(Project $objProject): ?CollectionModel {
        return ($objProject->collections()->orderBy(BaseModel::STAMP_CREATED, "desc")->first());
    }

    /**
     * @param string $collection
     *
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getCollectionFilesHistory(string $collection) {
        $arrHiddenField = [
            "file_size", "file_md5", "directory_uuid", CollectionModel::STAMP_CREATED, CollectionModel::STAMP_CREATED_BY,
            CollectionModel::STAMP_UPDATED, CollectionModel::STAMP_UPDATED_BY, "meta",
        ];
        $objCollection = $this->find($collection, true);

        return ($objCollection->collectionFilesHistory->makeHidden($arrHiddenField));
    }


    /**
     * @param CollectionModel $collection
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOrderedTracks(CollectionModel $collection) {
        return File::join("soundblock_collections_files", function ($join) use ($collection) {
            $join->on("soundblock_files.file_id", "=", "soundblock_collections_files.file_id")
                ->where("soundblock_collections_files.collection_id", $collection->collection_id)
                ->where("soundblock_files.file_category", "music");
        })->join("soundblock_tracks", "soundblock_files.file_id", "=", "soundblock_tracks.file_id")
            ->orderBy("soundblock_tracks.track_number", "asc")->get()
            ->makeHidden(["row_id", "row_uuid", "collection_id", "collection_uuid", BaseModel::STAMP_DELETED,
                          BaseModel::STAMP_DELETED_BY, BaseModel::DELETED_AT, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
                          "directory_uuid", "preview_start", "preview_stop"]);
    }

    /**
     * @param CollectionModel $objCollection
     * @param string|null $path
     * @return CollectionModel
     */
    public function getResources(CollectionModel $objCollection, ?string $path = null) {
        /** @var Collection $objLatestCollection */
        $objLatestCollection = $this->findLatestByProject($objCollection->project);

        $objCollection->load(["files" => function ($query) use ($path) {
            if (is_string($path)) {
                $query->whereRaw("lower(file_path) = (?)", strtolower($path));
            }

            $query->orderBy("file_sortby", "asc");
        }, "directories"              => function ($query) use ($path) {
            if (is_string($path)) {
                $query->whereRaw("lower(directory_path) = (?)", strtolower($path));
            }

            $query->orderBy("directory_path", "asc");
        }]);

        // When file category is music, sortby...
        if (strpos($path, "Music") === 0) {
            $orderedFiles = $objCollection->files->sortBy("track.track_volume_number")->values()->groupBy("track.track_volume_number");
            $orderedFiles = $orderedFiles->map(function ($files) {
                return ($files->sortBy("track.track_number")->values());
            })->flatten(1);
            unset($objCollection->files);
            $objCollection->files = $orderedFiles;
            $objCollection->files->map(function ($item){
                return (
                $item->track->load(
                    "language",
                    "languageVocals",
                    "primaryGenre",
                    "secondaryGenre",
                    "artists",
                    "contributors",
                    "lyrics",
                    "notes",
                    "publisher"
                )
                );
            });
        }

        if ($objLatestCollection->collection_id != $objCollection->collection_id) {
            /** @var \Illuminate\Database\Eloquent\Collection */
            $arrFile = $objCollection->files;
            $arrFile = $arrFile->map(function (File $item) use ($objLatestCollection) {
                /** @var int */
                $flag = Util::getRoot($objLatestCollection, $item);
                if ($flag == 0) {
                    $revertable = false;
                    $restorable = false;
                } else if ($flag == 1) {
                    $revertable = true;
                    $restorable = false;
                } else if ($flag == 2) {
                    $revertable = false;
                    $restorable = true;
                }
                $result = array_merge($item->toArray(), [
                    "restorable" => $restorable,
                    "revertable" => $revertable,
                ]);

                return ($result);
            });
            unset($objCollection->files);
            $objCollection->files = $arrFile;
        }



        return ($objCollection);
    }

    public function getCollectionOrderedTracks(CollectionModel $objCollection) {
        $objLatestCollection = $this->findLatestByProject($objCollection->project);

        $objCollection->load(["files" => function ($query) {
            $query->where("file_path", "Music");
        }]);

        $orderedFiles = $objCollection->files->sortBy("track.track_volume_number")->values()->groupBy("track.track_volume_number");
        $orderedFiles = $orderedFiles->map(function ($files) {
            return ($files->sortBy("track.track_number")->values());
        })->flatten(1);
        unset($objCollection->files);
        $objCollection->files = $orderedFiles;

        if ($objLatestCollection->collection_id != $objCollection->collection_id) {
            $arrFile = $objCollection->files;
            $arrFile = $arrFile->map(function (File $item) use ($objLatestCollection) {
                $flag = Util::getRoot($objLatestCollection, $item);
                if ($flag == 0) {
                    $revertable = false;
                    $restorable = false;
                } else if ($flag == 1) {
                    $revertable = true;
                    $restorable = false;
                } else if ($flag == 2) {
                    $revertable = false;
                    $restorable = true;
                }
                $result = array_merge($item->toArray(), [
                    "restorable" => $restorable,
                    "revertable" => $revertable,
                ]);

                return ($result);
            });
            unset($objCollection->files);
            $objCollection->files = $arrFile;
        }

        $objCollection->files->map(function ($item){
            return (
                $item->track->load(
                    "language",
                    "languageVocals",
                    "primaryGenre",
                    "secondaryGenre",
                    "artists",
                    "contributors",
                    "lyrics",
                    "notes",
                    "publisher"
                )
            );
        });

        return ($objCollection);
    }

    /**
     * @param CollectionModel $objCol
     * @return EloquentCollection
     */
    public function getTracks(CollectionModel $objCol) {
        return ($objCol->files()->where("file_category", "music")->get());
    }

    public function getTreeStructure(CollectionModel $objCol) {
        $roots = ["Music", "Video", "Merch", "Files"];
        $results = [];
        foreach ($roots as $root) {
            $category = strtolower($root);
            $results[$category] = $this->makeTree($root, $objCol);
        }
        return ($results);
    }

    /**
     * @param CollectionModel $collection
     * @param array $arrFileUuid
     * @return bool
     */
    public function hasFiles(CollectionModel $collection, array $arrFileUuid): bool {
        $collectionFiles = $collection->files()->wherePivotIn("file_uuid", $arrFileUuid)->get();

        return ($collectionFiles->count() == count($arrFileUuid));
    }

    /**
     * @param CollectionModel $objNew
     * @param CollectionModel $objCol
     * @param EloquentCollection|null $arrDirs
     * @param EloquentCollection|null $arrFiles
     * @param User|null $objUser
     * @return CollectionModel
     * @throws \Exception
     */
    public function attachResources(CollectionModel $objNew, CollectionModel $objCol, ?EloquentCollection $arrDirs = null, ?EloquentCollection $arrFiles = null, ?User $objUser = null) {
        if (is_null($arrDirs)) {
            $directories = $objCol->directories;
        } else {
            $directories = $arrDirs;
        }

        if (is_null($arrFiles)) {
            $files = $objCol->files;
        } else {
            $files = $arrFiles;
        }

        if (!$objUser) {
            $objUser = Auth::user();
        }

        foreach ($directories as $directory) {
            $objNew->directories()->attach($directory->directory_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $objNew->collection_uuid,
                "directory_uuid"            => $directory->directory_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);
        }

        foreach ($files as $file) {
            $objNew->files()->attach($file->file_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $objNew->collection_uuid,
                "file_uuid"                 => $file->file_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $objUser->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $objUser->user_id,
            ]);
        }

        return ($objNew);
    }

    /**
     * @param CollectionModel $collection
     * @param EloquentCollection $files
     * @param User|null $user
     * @return CollectionModel
     * @throws \Exception
     */
    public function attachFiles(CollectionModel $collection, EloquentCollection $files, ?User $user = null): CollectionModel {
        if (!$user) {
            /** @var User */
            $user = Auth::user();
        }

        foreach ($files as $file) {
            $collection->files()->attach($file->file_id, [
                "row_uuid"                  => Util::uuid(),
                "collection_uuid"           => $collection->collection_uuid,
                "file_uuid"                 => $file->file_uuid,
                BaseModel::STAMP_CREATED    => time(),
                BaseModel::STAMP_CREATED_BY => $user->user_id,
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => $user->user_id,
            ]);
        }

        return ($collection);
    }

    private function applyFilterCategory($changedEntity, $queryBuilder) {
        switch (strtolower($changedEntity)){
            case "music":
                $queryBuilder = $queryBuilder->orWhere("flag_changed_music", true);
                break;
            case "video":
                $queryBuilder = $queryBuilder->orWhere("flag_changed_video", true);
                break;
            case "merchandising":
            case "merch":
                $queryBuilder = $queryBuilder->orWhere("flag_changed_merchandising", true);
                break;
            case "files":
                $queryBuilder = $queryBuilder->orWhere("flag_changed_other", true);
                break;
        }

        return $queryBuilder;
    }

    protected function makeTree($root, CollectionModel $objCol, array $tree = null, int $parent = null) {
        if (is_null($tree)) {
            $tree = [];
        }

        $arrFiles = $objCol->files()->where("file_path", $root)->get();

        if ($parent) {
            $arrDirs = $objCol->directories()->where("parent_id", $parent)->get();
        } else {
            $arrDirs = $objCol->directories()->where("directory_category", $root)->whereNull("parent_id")->get();
        }

        foreach ($arrFiles as $objFile) {
            array_push($tree, [
                "file_uuid"              => $objFile->file_uuid,
                "file_name"              => $objFile->file_name,
                "file_path"              => $objFile->file_path,
                "file_category"          => $objFile->file_category,
                "file_sortby"            => $objFile->file_sortby,
                "kind"                   => "file",
                BaseModel::STAMP_CREATED => $objFile->stamp_created,
                BaseModel::STAMP_UPDATED => $objFile->stamp_updated,
            ]);
        }

        foreach ($arrDirs as $objDir) {
            array_push($tree, [
                    "directory_uuid"         => $objDir->directory_uuid,
                    "directory_name"         => $objDir->directory_name,
                    "directory_category"     => $objDir->directory_category,
                    "directory_path"         => $objDir->directory_path,
                    "directory_sortby"       => $objDir->directory_sortby,
                    "kind"                   => "directory",
                    BaseModel::STAMP_CREATED => $objDir->stamp_created,
                    BaseModel::STAMP_UPDATED => $objDir->stamp_updated,
                ]
            );
            $childClone = &$tree[count($tree) - 1]["children"];
            $childClone = $this->makeTree($objDir->directory_sortby, $objCol, $childClone, $objDir->directory_id);
        }

        return ($tree);
    }
}
