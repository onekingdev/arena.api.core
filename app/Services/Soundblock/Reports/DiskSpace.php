<?php


namespace App\Services\Soundblock\Reports;


use App\Contracts\Soundblock\Reports\DiskSpace as DiskSpaceContract;
use App\Models\Soundblock\Projects\Project;
use App\Repositories\Soundblock\Reports\DiskSpace as DiskSpaceRepository;

class DiskSpace implements DiskSpaceContract {
    /**
     * @var DiskSpaceRepository
     */
    private DiskSpaceRepository $diskspaceReport;

    public function __construct(DiskSpaceRepository $diskspaceReport) {
        $this->diskspaceReport = $diskspaceReport;
    }

    public function create(Project $objProject, int $intValue, string $strDate) {
        return $this->diskspaceReport->save($objProject, $intValue, $strDate);
    }

    public function createMonthly(Project $objProject, int $intValue, string $strDate) {
        return $this->diskspaceReport->saveMonthly($objProject, $intValue, $strDate);
    }
}