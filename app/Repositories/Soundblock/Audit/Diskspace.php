<?php

namespace App\Repositories\Soundblock\Audit;

use Util;
use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Audit\Diskspace as DiskspaceModel;

class Diskspace extends BaseRepository {
    /**
     * Diskspace constructor.
     * @param DiskspaceModel $model
     */
    public function __construct(DiskspaceModel $model) {
        $this->model = $model;
    }

    public function getByDate(string $strDate) {
        return ($this->model->whereDate(BaseModel::CREATED_AT, "=", $strDate)
            ->select(DB::raw("SUM(file_size) as sum_file_size"), "project_uuid"))->groupBy("project_uuid")->get();
    }

    public function getSumByDateRange(string $strStartDate, string $strEndDate) {
        return ($this->model->whereDate(BaseModel::CREATED_AT, ">=", $strStartDate)->whereDate(BaseModel::CREATED_AT, "<=", $strEndDate)
            ->select(DB::raw("SUM(file_size) as sum_file_size"), "project_uuid"))->groupBy("project_uuid")->get();
    }

    public function save(Project $objProject, int $intFileSize) {
        return $objProject->diskSpaceAudit()->create([
            "row_uuid"     => Util::uuid(),
            "project_uuid" => $objProject->project_uuid,
            "file_size"    => $intFileSize,
        ]);
    }
}
