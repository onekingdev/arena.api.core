<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Models\BaseModel;
use App\Models\Users\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Soundblock\Accounts\Account;
use App\Contracts\Soundblock\Contracts\SmartContracts;
use App\Models\Soundblock\Projects\Project as ProjectModel;

class Project extends BaseRepository {
    /**
     * @param ProjectModel $objProject
     */
    public function __construct(ProjectModel $objProject) {
        $this->model = $objProject;
    }

    /**
     * @param array $where
     * @param string $field = "uuid"
     * @param int|null $perPage = null
     *
     * @param string $sortBy
     * @param array|null $invitedAccounts
     * @return mixed
     * @throws \Exception
     */
    public function findAllWhere(array $where, string $field = "uuid", ?int $perPage = null, string $sortBy = "last_updated", ?array $invitedAccounts = null) {
        if (($field == "uuid" || $field == "id")) {
            $queryBuilder = $this->model->whereIn("project_" . $field, $where);
        } else {
            throw new \Exception("Invalid Parameter.", 400);
        }

        if (is_array($invitedAccounts)) {
            $queryBuilder = $queryBuilder->whereNotIn("account_uuid", $invitedAccounts);
        }

        $queryBuilder = $queryBuilder->with("deployments.platform", "artist", "format");

        switch ($sortBy) {
            case "project_date":
                $queryBuilder = $queryBuilder->latest("project_date");
                break;
            case "oldest_update":
                $queryBuilder = $queryBuilder->oldest("stamp_updated_at");
                break;
            case "last_updated":
            default:
                $queryBuilder = $queryBuilder->latest("stamp_updated_at");
                break;
        }

        if ($perPage) {
            $arrProjects = $queryBuilder->paginate($perPage)->withPath(route("get-projects"));
        } else {
            $arrProjects = $queryBuilder->get();
        }

        return ($arrProjects);
    }

    public function findAll(array $arrData, ?int $perPage = null, array $arrSort = []) {
        $query = $this->model->newQuery()->with(["account", "deployments"]);

        if (isset($arrData["project_name"])) {
            $query = $query->whereRaw("lower(project_title) like (?)", "%" . strtolower($arrData["project_name"]) . "%");
        }

        if (isset($arrData["account"]) && is_string($arrData["account"])) {
            $query = $query->where("account_uuid", $arrData["account"]);
        }

        if (isset($arrSort["sort_name"])) {
            $query->orderBy("project_title", $arrSort["sort_name"]);
        }

        if (isset($arrSort["sort_type"])) {
            $query->orderBy("project_type", $arrSort["sort_type"]);
        }

        if (isset($arrSort["sort_created_at"])) {
            $query->orderBy("stamp_created_at", $arrSort["sort_created_at"]);
        }

        [$query, $availableMetaData] = $this->applyMetaFilters($arrData, $query);

        if ($perPage) {
            $arrProjects = $query->paginate($perPage);
        } else {
            $arrProjects = $query->get();
        }

        return ([$arrProjects, $availableMetaData]);
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function findAllLikeName(string $search){
        return ($this->model->whereRaw("lower(project_title) like (?)", "%" . Util::lowerLabel($search) . "%")->get());
    }

    /**
     * @param string $search
     * @return mixed
     */
    public function findAllWithAccountsLikeName(string $search){
        return (
            $this->model->whereRaw("lower(project_title) like (?)", "%" . Util::lowerLabel($search) . "%")
                ->orWhereHas("account", function ($query) use ($search){
                    $query->whereRaw("lower(soundblock_accounts.account_name) like (?)", "%" . Util::lowerLabel($search) . "%");
                })
                ->get()
        );
    }

    /**
     * @param string $account
     * @param string $user
     * @return mixed
     */
    public function findAllByUserAndAccount(string $account, string $user){
        $objProjects = $this->model->where("account_uuid", $account)->whereHas("team", function ($query) use ($user) {
            $query->whereHas("users", function ($query) use ($user) {
                $query->where("soundblock_projects_teams_users.user_uuid", $user)
                    ->whereNull("soundblock_projects_teams_users." . BaseModel::STAMP_DELETED);
            });
        })->get();

        return ($objProjects);
    }

    public function findByAccountAndUser(Account $objAccount, User $objUser) {
        return $objAccount->projects()->whereHas("team.users", function (Builder $query) use ($objUser) {
            $query->where("users.user_id", $objUser->user_id);
        })->get();
    }

    public function typeahead(array $arrData) {
        $objQuery = $this->model->newQuery();

        if (isset($arrData["project"])) {
            $objQuery = $objQuery->where("project_title", "like", "%{$arrData["project"]}%");
        }

        if (isset($arrData["account"])) {
            $objQuery = $objQuery->where("account_uuid", $arrData["account"]);
        }

        if (isset($arrData["artist"])) {
            $objQuery = $objQuery->where("artist_uuid", $arrData["artist"]);
        }

        return $objQuery->get();
    }

    /**
     * @param array $arrProjectIds
     * @param array $deploymentStatus
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function __getAllByDeploymentStatus(array $arrProjectIds, array $deploymentStatus) {
        return $this->model->with(["deployments.platform"])
            ->whereHas("deployments", function (Builder $query) use ($deploymentStatus) {
                $deploymentStatus = array_map([Util::class, "ucfLabel"], $deploymentStatus);
                $query->whereIn("deployment_status", $deploymentStatus);
            })->whereIn("project_id", $arrProjectIds)->get();
    }

    /**
     * @param ProjectModel $objProject
     * @param string $user
     * @return mixed
     */
    public function checkUserPartOfContract(ProjectModel $objProject, string $user){
        $smartContracts = resolve(SmartContracts::class);
        $objContract = $smartContracts->findLatest($objProject, false);

        if (empty($objContract)) {
            return (null);
        }

        return (
        $objContract->users()
            ->where("soundblock_projects_contracts_users.contract_version", $objContract->contract_version)
            ->where("soundblock_projects_contracts_users.user_uuid", $user)
            ->where("soundblock_projects_contracts_users.flag_action", "!=", "delete")
            ->whereNull("soundblock_projects_contracts_users." . BaseModel::STAMP_DELETED)
            ->first()
        );
    }
}
