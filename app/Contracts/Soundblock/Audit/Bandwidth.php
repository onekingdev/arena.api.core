<?php

namespace App\Contracts\Soundblock\Audit;

use App\Models\Users\User;
use App\Models\Soundblock\Projects\Project as ProjectModel;

interface Bandwidth {
    public const UPLOAD = "upload";
    public const DOWNLOAD = "download";

    public function create(ProjectModel $objProject, User $objUser, int $intFileSize, string $flagAction);

    public function getByDate(string $date);
    public function getSumByDaysRange(string $strStartDate, string $strEndDate);
}