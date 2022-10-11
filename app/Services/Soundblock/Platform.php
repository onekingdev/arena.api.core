<?php

namespace App\Services\Soundblock;

use App\Models\Soundblock\Platform as PlatformModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Repositories\Soundblock\Platform as PlatformRepository;
use App\Models\Soundblock\Collections\Collection as CollectionModel;

class Platform {
    protected PlatformRepository $platformRepo;

    /**
     * Platform constructor.
     * @param PlatformRepository $platformRepo
     */
    public function __construct(PlatformRepository $platformRepo) {
        $this->platformRepo = $platformRepo;
    }

    /**
     * @param array $arrParams
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $arrParams) {
        return ($this->platformRepo->create(["name" => $arrParams["name"]]));
    }

    /**
     * @param $id
     * @param bool|null $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find($id, ?bool $bnFailure = true) {
        return ($this->platformRepo->find($id, $bnFailure));
    }

    /**
     * @param string|null $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findAll(?string $category = null) {
        return ($this->platformRepo->findAll(10, $category));
    }

    public function findAllWithoutPaginate(){
        return ($this->platformRepo->findAll());
    }

    /**
     * @param ProjectModel $project
     * @param string|null $category
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findNotDeployedForProject(ProjectModel $project, ?string $category = null) {
        $arrDeployed = $project->deployments()->pluck("platform_id")->toArray();

        return ($this->platformRepo->findNotIn($arrDeployed, $category));
    }

    /**
     * @param CollectionModel $collection
     * @param string|null $category
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function findNotDeployedForCollection(CollectionModel $collection, ?string $category = null) {
        $arrDeployed = $collection->deployments()->pluck("platform_id")->toArray();

        return ($this->platformRepo->findNotIn($arrDeployed, $category));
    }

    /**
     * @param PlatformModel $objPlatform
     * @param array $arrParams
     * @return mixed
     */
    public function update(PlatformModel $objPlatform, array $arrParams) {
        $arrPlatform = [];
        if (isset($arrParams["name"])) {
            $arrPlatform["name"] = $arrParams["name"];
        }

        return ($this->platformRepo->update($objPlatform, $arrPlatform));
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function autocomplete(string $name){
        $returnData = [];
        $objPlatforms = $this->platformRepo->findAllLikeName($name);

        if ($objPlatforms) {
            foreach ($objPlatforms as $platform) {
                $returnData[] = ["name" => $platform->name, "user_uuid" => $platform->platform_uuid];
            }

            return ($returnData);
        }

        return null;
    }
}
