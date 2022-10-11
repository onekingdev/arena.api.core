<?php

namespace App\Services\Soundblock\Audit;

use App\Models\Users\User;
use App\Repositories\Soundblock\ProjectsBandwidth;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Contracts\Soundblock\Audit\Bandwidth as BandwidthContract;

class Bandwidth implements BandwidthContract {
    /** @var ProjectsBandwidth */
    private ProjectsBandwidth $projectsBandwidthRepository;

    /**
     * Bandwidth constructor.
     * @param ProjectsBandwidth $projectsBandwidthRepository
     */
    public function __construct(ProjectsBandwidth $projectsBandwidthRepository) {
        $this->projectsBandwidthRepository = $projectsBandwidthRepository;
    }

    public function getByDate(string $date) {
        return $this->projectsBandwidthRepository->getBandwidthByDate($date);
    }

    public function getSumByDaysRange(string $strStartDate, string $strEndDate) {
        return $this->projectsBandwidthRepository->getSumByDateRange($strStartDate, $strEndDate);
    }

    public function create(ProjectModel $objProject, User $objUser, int $intFileSize, string $flagAction) {
        return $this->projectsBandwidthRepository->store($objProject, $objUser, $intFileSize, $flagAction);
    }
}
