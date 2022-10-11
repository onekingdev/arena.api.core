<?php

namespace App\Contracts\Soundblock\Audit;

use App\Models\Soundblock\Projects\Project;

interface Diskspace {
    public function save(Project $objProject, int $fileSize);

    public function getByDate(string $strDate);
    public function getSumByDateRange(string $strStartDate, string $strEndDate);
}