<?php

namespace App\Models\Soundblock\Audit;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diskspace extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_audit_diskspace";

    protected $primaryKey = "row_id";

    protected $guarded = [];
}
