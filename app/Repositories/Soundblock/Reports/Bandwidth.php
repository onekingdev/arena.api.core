<?php

namespace App\Repositories\Soundblock\Reports;

use Util;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Reports\BandwidthReport;
use App\Repositories\BaseRepository;

class Bandwidth extends BaseRepository {
    /**
     * Bandwidth constructor.
     * @param BandwidthReport $model
     */
    public function __construct(BandwidthReport $model) {
        $this->model = $model;
    }

    public function save(Project $objProject, int $intValue, string $strDate) {
        return $objProject->bandwidthReport()->create([
            "row_uuid"     => Util::uuid(),
            "project_uuid" => $objProject->project_uuid,
            "report_value" => $intValue,
            "report_date"  => $strDate,
        ]);
    }

    public function getBandwidthReport($project, string $strDateStart, string $strDateEnd) {
        $objQuery = $this->model->whereDate("report_date", ">=", $strDateStart)->whereDate("report_date", "<=", $strDateEnd);

        if ($project instanceof Project) {
            $objQuery = $objQuery->where("project_id", $project->project_id);
        } elseif (is_array($project)) {
            $objQuery = $objQuery->whereIn("project_id", $project);
        }

        return $objQuery->get();
    }
}
