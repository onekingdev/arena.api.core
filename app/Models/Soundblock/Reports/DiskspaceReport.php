<?php

namespace App\Models\Soundblock\Reports;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiskspaceReport extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_reports_diskspace";

    protected $primaryKey = "row_id";
}
