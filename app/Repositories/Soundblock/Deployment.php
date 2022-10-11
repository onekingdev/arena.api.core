<?php

namespace App\Repositories\Soundblock;

use Util;
use Carbon\Carbon;
use App\Repositories\BaseRepository;
use App\Models\{
    BaseModel,
    Soundblock\Platform,
    Soundblock\Projects\Project,
    Soundblock\Collections\Collection,
    Soundblock\Projects\Deployments\Deployment as DeploymentModel
};

class Deployment extends BaseRepository {
    public function __construct(DeploymentModel $objDeployment) {
        $this->model = $objDeployment;
    }

    public function findAllByProject(Project $objProject, array $arrParams = [], ?int $perPage = null) {
        $query = $this->model;

        $query = $query->where("soundblock_projects_deployments.project_id", $objProject->project_id);

        if (isset($arrParams["sort_platform"])) {
            $query = $query->orderBy("soundblock_data_platforms.name", Util::lowerLabel($arrParams["sort_platform"]));
        }

        if (isset($arrParams["sort_deployment_status"])) {
            $query = $query->orderBy("soundblock_projects_deployments.deployment_status", Util::lowerLabel($arrParams["sort_deployment_status"]));
        }

        if (isset($arrParams["sort_stamp_updated"])) {
            $query = $query->orderBy(BaseModel::STAMP_UPDATED, Util::lowerLabel($arrParams["sort_stamp_updated"]));
        }

        $query = $query->with("platform");

        if ($perPage) {
            $arrDeployments = $query->paginate($perPage);
        } else {
            $arrDeployments = $query->get();
        }

        return ($arrDeployments);
    }

    public function findLatest(Project $project): ?DeploymentModel {
        return ($this->model->whereHas("project", function ($query) use ($project) {
            $query->where("project_id", $project->project_id);
        })->orderBy("collection_id", "desc")->first());
    }

    public function findAllWithRelationsAndStatus(array $arrRelations, array $arrStatus, int $per_page, array $arrData, array $arrSort = [], bool $bnGroupByCollection = false) {
        $query = $this->model->whereIn("deployment_status", $arrStatus)->select("soundblock_projects_deployments.*")->with($arrRelations)
            ->join("soundblock_projects", "soundblock_projects_deployments.project_id", "=", "soundblock_projects.project_id")
            ->join("soundblock_accounts", "soundblock_accounts.account_id", "=", "soundblock_projects.account_id")
            ->join("soundblock_accounts_plans", function ($query) use ($arrData) {
                $query->on("soundblock_accounts.account_id", "=", "soundblock_accounts_plans.account_id")
                    ->where("soundblock_accounts_plans.flag_active", true);

                if (isset($arrData["plan_type"])) {
                    $query->where("soundblock_accounts_plans.plan_type", $arrData["plan_type"]);
                }
            });

        if (isset($arrData["project"])) {
            $query = $query->where("soundblock_projects_deployments.project_uuid", $arrData["project"]);
        } else if (isset($arrData["project_uuids"])) {
            $query = $query->whereIn("soundblock_projects_deployments.project_uuid", $arrData["project_uuids"]);
        }

        if (isset($arrData["account_uuids"])) {
            $query = $query->whereIn("soundblock_projects.account_uuid", $arrData["account_uuids"]);
        }

        if (isset($arrData["platform_uuids"])) {
            $query = $query->whereIn("soundblock_projects_deployments.platform_uuid", $arrData["platform_uuids"]);
        }

        if (isset($arrData["date_from"])) {
            $query = $query->where("soundblock_projects_deployments.stamp_created_at", ">=", $arrData["date_from"]);
        }

        if (isset($arrData["date_to"])) {
            $date = Carbon::create($arrData["date_to"])->endOfDay();
            $query = $query->where("soundblock_projects_deployments.stamp_created_at", "<=", $date);
        }

        if (isset($arrSort["sort_project"])) {
            $query->orderBy("soundblock_projects.project_title", $arrSort["sort_project"]);
        } elseif (isset($arrSort["sort_created_at"])) {
            $query->orderBy("soundblock_projects_deployments.stamp_created_at", $arrSort["sort_created_at"]);
        } else {
            $query->orderBy("soundblock_projects_deployments.stamp_created_at", "desc");
        }

        if ($bnGroupByCollection) {
            $query = $query->groupBy("soundblock_projects_deployments.collection_uuid");
        }

        [$query, $availableMetaData] = $this->applyMetaFilters($arrData, $query);

        return ([$query->paginate($per_page), $availableMetaData]);
    }

    /**
     * @param string $project
     * @param int $perPage
     * @return mixed
     */
    public function findProjectDeployments(string $project, int $perPage) {
        $query = $this->model->where("project_uuid", $project)->with(["project", "platform", "collection"]);

        return ($query->paginate($perPage));
    }

    /**
     * @param Collection $collection
     * @param Platform $platform
     *
     * @return bool
     */
    public function canDeployOnPlatform(Collection $collection, Platform $platform) {
        return (!$this->model->where("collection_id", $collection->collection_id)
            ->where("platform_id", $platform->platform_id)->exists());
    }

    public function createModel(array $arrParams) {
        $objDeployment = new DeploymentModel;

        $objDeployment->deployment_uuid = Util::uuid();
        $objDeployment->project_id = $arrParams["project_id"];
        $objDeployment->project_uuid = $arrParams["project_uuid"];
        $objDeployment->platform_id = $arrParams["platform_id"];
        $objDeployment->platform_uuid = $arrParams["platform_uuid"];
        $objDeployment->collection_id = $arrParams["collection_id"];
        $objDeployment->collection_uuid = $arrParams["collection_uuid"];
        $objDeployment->deployment_status = config("constant.soundblock.deployment_status")["pending"];

        $objDeployment->save();

        return ($objDeployment);
    }
}
