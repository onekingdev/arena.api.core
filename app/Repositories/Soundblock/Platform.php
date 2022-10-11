<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Platform as PlatformModel;

class Platform extends BaseRepository {
    public function __construct(PlatformModel $objPlatform) {
        $this->model = $objPlatform;
    }

    public function findAll(?int $perPage = null, ?string $category = null) {
        $queryBuilder = $this->model->newQuery()->orderBy("name");

        if (is_string($category)) {
            switch (strtolower($category)) {
                case "music":
                    $queryBuilder = $queryBuilder->where("flag_music", true);
                break;
                case "video":
                    $queryBuilder = $queryBuilder->where("flag_video", true);
                break;
                case "merchandising":
                    $queryBuilder = $queryBuilder->where("flag_merchandising", true);
                break;

            }
        }

        if ($perPage) {
            return ($queryBuilder->paginate($perPage));
        }

        return ($queryBuilder->get());
    }

    public function findMany(array $platformsUuid) {
        return $this->model->whereIn("platform_uuid", $platformsUuid)->get();
    }

    public function findNotIn(array $platformsId, ?string $category = null) {
        $queryBuilder = $this->model->newQuery();

        if (is_string($category)) {
            switch (strtolower($category)) {
                case "music":
                    $queryBuilder = $queryBuilder->where("flag_music", true);
                    break;
                case "video":
                    $queryBuilder = $queryBuilder->where("flag_video", true);
                    break;
                case "merchandising":
                    $queryBuilder = $queryBuilder->where("flag_merchandising", true);
                    break;

            }        }

        return $queryBuilder->orderBy("name")->whereNotIn("platform_id", $platformsId)->get();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findAllLikeName(string $name){
        return ($this->model->whereRaw("lower(name) like (?)", "%" . Util::lowerLabel($name) . "%")->get());
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name){
        return ($this->model->where("name", $name)->first());
    }
}
