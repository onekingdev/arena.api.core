<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Models\BaseModel;
use App\Models\Users\User;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Accounts\Account as AccountModel;
use App\Models\Soundblock\Audit\Bandwidth as ProjectsBandwidthModel;
use Illuminate\Support\Facades\DB;

class ProjectsBandwidth extends BaseRepository {
    /**
     * ProjectsBandwidth constructor.
     * @param ProjectsBandwidthModel $model
     */
    public function __construct(ProjectsBandwidthModel $model) {
        $this->model = $model;
    }

    public function store(ProjectModel $objProject, User $objUser, int $intFileSize, string $flagAction) {
        return $objProject->bandwidth()->create([
            "row_uuid"     => Util::uuid(),
            "project_uuid" => $objProject->project_uuid,
            "user_id"      => $objUser->user_id,
            "user_uuid"    => $objUser->user_uuid,
            "file_size"    => $intFileSize,
            "flag_action"  => $flagAction,
        ]);
    }

    public function getTransferSizeByAccountAndDates(AccountModel $objAccount, string $dateStart, string $dateEnd){
        $arrObjProjects = $objAccount->projects;

        return (
            $this->model->whereIn("project_id", $arrObjProjects->pluck("project_id")->toArray())
                ->where(BaseModel::CREATED_AT, ">=", $dateStart)
                ->where(BaseModel::CREATED_AT, "<=", $dateEnd)
                ->sum("file_size")
        );
    }

    public function getBandwidthByDate(string $date) {
        return ($this->model->whereDate(BaseModel::CREATED_AT, "=", $date)
            ->select(DB::raw("SUM(file_size) as sum_file_size"), "project_uuid"))->groupBy("project_uuid")->get();
    }

    public function getSumByDateRange(string $strStartDate, string $strEndDate) {
        return ($this->model->whereDate(BaseModel::CREATED_AT, ">=", $strStartDate)->whereDate(BaseModel::CREATED_AT, "<=", $strEndDate)
            ->select(DB::raw("SUM(file_size) as sum_file_size"), "project_uuid"))->groupBy("project_uuid")->get();
    }

    public function getProjectTodayValues($project) {
        $objQuery = $this->model->whereDate(BaseModel::CREATED_AT, now()->format("Y-m-d"))
            ->select(DB::raw("SUM(file_size) as sum_file_size"));

        if ($project instanceof ProjectModel) {
            $objQuery = $objQuery->where("project_id", $project->project_id);
        } elseif (is_array($project)) {
            $objQuery = $objQuery->whereIn("project_id", $project);
        }

        return ($objQuery->first());
    }
}
