<?php

namespace App\Repositories\Soundblock;

use Util;
use Auth;
use Constant;
use Exception;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\{BaseModel, Soundblock\Collections\Collection, Soundblock\Files\Directory as DirectoryModel};

class Directory extends BaseRepository {
    /**
     * @param DirectoryModel $objDirectory
     * @return void
     */
    public function __construct(DirectoryModel $objDirectory) {
        $this->model = $objDirectory;
    }

    /**
     * @param Collection $collection
     * @param string $path
     * @return DirectoryModel
     */
    public function findByPath(Collection $collection, string $path): ?DirectoryModel {
        return ($collection->directories()->where("directory_sortby", $path)
                           ->orderBy("directory_sortby", "asc")->first());
    }

    /**
     * @param Collection $collection
     * @param string $path
     * @return SupportCollection
     */
    public function findAllUnderPath(Collection $collection, string $path): SupportCollection {
        return ($collection->directories()->where("directory_sortby", "like", $path . Constant::Separator . "%")
                           ->orderBy("directory_sortby", "asc")->get());
    }

    /**
     * @param Collection $collection
     * @param string $path
     * @return SupportCollection
     */
    public function findAllByPath(Collection $collection, string $path): SupportCollection {
        return ($this->model->whereHas("collections", function (Builder $query) use ($collection, $path) {
            $query->where("soundblock_collections.collection_id", $collection->collection_id);
            $query->where(function ($where) use ($path) {
                $where->where("soundblock_files_directories.directory_sortby", "like", $path . Constant::Separator . "%")
                      ->orWhere("soundblock_files_directories.directory_sortby", $path);
            });
        })->get());
    }

    /**
     * @param DirectoryModel $objDir
     * @param Collection $objCol
     * @return SupportCollection
     */
    public function getFilesInDir(DirectoryModel $objDir, Collection $objCol): SupportCollection {
        return ($objCol->files()->where("file_path", "like", $objDir->directory_sortby . "%")
                       ->orderBy("file_sortby", "asc")->get());
    }

    /**
     * @param DirectoryModel $objDir
     * @return array
     */
    public function getParams(DirectoryModel $objDir): array {
        return ($objDir->makeHidden([$objDir->uuid(), BaseModel::STAMP_CREATED, BaseModel::STAMP_UPDATED])->toArray());
    }

    /**
     * @param array $arrParams
     * @param Collection $newCollection
     * @return DirectoryModel
     * @throws \Exception
     */
    public function createModel(array $arrParams, Collection $newCollection): DirectoryModel {
        $model = new DirectoryModel;
        $parentDir = null;

        if (isset($arrParams["parent_directory"])) {
            $objParentDirectory = $this->find($arrParams["parent_directory"]);
            $parentDir = $objParentDirectory->directory_id;

            if ($objParentDirectory->directory_sortby !== $arrParams["directory_path"]) {
                throw new Exception("Invalid Directory Path");
            }
        }

        if (!isset($arrParams["directory_uuid"]))
            $arrParams["directory_uuid"] = Util::uuid();
        if (!isset($arrParams["directory_sortby"])) {
            $arrParams["directory_sortby"] = $arrParams["directory_path"] . Constant::Separator . $arrParams["directory_name"];
        }
        $arrParams = Util::rename_directory($newCollection, $arrParams);

        $model->directory_uuid     = $arrParams["directory_uuid"];
        $model->directory_name     = $arrParams["directory_name"];
        $model->directory_path     = $arrParams["directory_path"];
        $model->directory_sortby   = $arrParams["directory_sortby"];
        $model->directory_category = $arrParams["directory_category"];
        $model->parent_id          = $parentDir;
        $model->save();

        $model->collections()->attach($newCollection->collection_id, [
            "row_uuid"                  => Util::uuid(),
            "collection_uuid"           => $newCollection->collection_uuid,
            "directory_uuid"            => $model->directory_uuid,
            BaseModel::STAMP_CREATED    => time(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_CREATED_BY => Auth::id(),
            BaseModel::STAMP_UPDATED_BY => Auth::id(),
        ]);
        return ($model);
    }
}
