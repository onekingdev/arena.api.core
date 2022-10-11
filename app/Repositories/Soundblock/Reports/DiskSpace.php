<?php


namespace App\Repositories\Soundblock\Reports;


use Util;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Reports\DiskspaceReport;
use App\Repositories\BaseRepository;

class DiskSpace extends BaseRepository {
    /**
     * DiskSpace constructor.
     * @param DiskspaceReport $model
     */
    public function __construct(DiskspaceReport $model) {
        $this->model = $model;
    }

    public function save(Project $objProject, int $intValue, string $strDate) {
        $objReport = $objProject->diskSpaceReport()->whereDate("report_date", $strDate)->first();

        if (is_null($objReport)) {
            return $objProject->diskSpaceReport()->create([
                "row_uuid"     => Util::uuid(),
                "project_uuid" => $objProject->project_uuid,
                "report_value" => $intValue,
                "report_date"  => $strDate,
            ]);
        }

        $objReport->report_value = $intValue;
        $objReport->save();

        return $objReport;
    }

    public function saveMonthly(Project $objProject, int $intValue, string $strDate) {
        return $objProject->diskSpaceMontlyReport()->create([
            "row_uuid"     => Util::uuid(),
            "project_uuid" => $objProject->project_uuid,
            "report_value" => $intValue,
            "report_date"  => $strDate,
        ]);
    }

    public function getDiskspaceReport($project, string $strDateStart, string $strDateEnd) {
        $objQuery = $this->model->whereDate("report_date", ">=", $strDateStart)->whereDate("report_date", "<=", $strDateEnd);

        if ($project instanceof Project) {
            $objQuery = $objQuery->where("project_id", $project->project_id);
        } elseif (is_array($project)) {
            $objQuery = $objQuery->whereIn("project_id", $project);
        }

        return $objQuery->get();
    }

    public function getSumDiskSpaceSize($project, string $strDateStart, string $strDateEnd){
        $objQuery = $this->model->whereDate("report_date", ">=", $strDateStart)->whereDate("report_date", "<=", $strDateEnd);

        if ($project instanceof Project) {
            $objQuery = $objQuery->where("project_id", $project->project_id);
        } elseif (is_array($project)) {
            $objQuery = $objQuery->whereIn("project_id", $project);
        }

        return $objQuery->sum("report_value");
    }
}
