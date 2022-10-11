<?php

namespace App\Services\Soundblock\Audit;

use App\Models\Soundblock\Projects\Project;
use App\Contracts\Soundblock\Audit\Diskspace as DiskspaceAuditContract;
use App\Repositories\Soundblock\Audit\Diskspace as DiskSpaceRepository;

class DiskSpace implements DiskspaceAuditContract {
    /** @var DiskSpaceRepository */
    private DiskSpaceRepository $diskspaceRepository;

    /**
     * DiskSpaceAudit constructor.
     * @param DiskSpaceRepository $diskspaceRepository
     */
    public function __construct(DiskSpaceRepository $diskspaceRepository) {
        $this->diskspaceRepository = $diskspaceRepository;
    }

    public function getByDate(string $strDate) {
        return $this->diskspaceRepository->getByDate($strDate);
    }

    public function getSumByDateRange(string $strStartDate, string $strEndDate) {
        return $this->diskspaceRepository->getSumByDateRange($strStartDate, $strEndDate);
    }

    public function save(Project $objProject, int $fileSize) {
        return $this->diskspaceRepository->save($objProject, $fileSize);
    }
}
