<?php

namespace App\Contracts\Soundblock\Reports;

use App\Models\Soundblock\Projects\Project;

interface Bandwidth {
    public function create(Project $objProject, int $intValue, string $strDate);
    public function createMonthly(Project $objProject, int $intValue, string $strDate);
}