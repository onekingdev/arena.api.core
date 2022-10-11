<?php

namespace App\Models\Soundblock\Audit;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bandwidth extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_audit_bandwidth";

    protected $primaryKey = "row_id";

    protected $hidden = [];

    protected $guarded = [];
}