<?php

namespace App\Services\Soundblock\Reports;

use App\Contracts\Soundblock\Reports\Bandwidth as BandwidthContract;
use Util;
use App\Models\Soundblock\Projects\Project;

class Bandwidth implements BandwidthContract {
    public function create(Project $objProject, int $intValue, string $strDate) {
        $objReport = $objProject->bandwidthReport()->whereDate("report_date", $strDate)->first();

        if (is_null($objReport)) {
            return $objProject->bandwidthReport()->create([
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

    public function createMonthly(Project $objProject, int $intValue, string $strDate) {
        return $objProject->bandwidthMontlyReport()->create([
            "row_uuid"     => Util::uuid(),
            "project_uuid" => $objProject->project_uuid,
            "report_value" => $intValue,
            "report_date"  => $strDate,
        ]);
    }
}