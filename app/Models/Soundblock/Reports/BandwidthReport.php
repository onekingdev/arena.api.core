<?php

namespace App\Models\Soundblock\Reports;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BandwidthReport extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_reports_bandwidth";

    protected $primaryKey = "row_id";
}
