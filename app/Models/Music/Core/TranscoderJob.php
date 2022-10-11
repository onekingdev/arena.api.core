<?php

namespace App\Models\Music\Core;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TranscoderJob extends BaseModel {
    use HasFactory;

    protected $connection = "mysql-music";

    protected $primaryKey = "job_id";

    protected $hidden = [
        "job_id", "project_id", "aws_job_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    protected $casts = [
        "job_input"  => "array",
        "job_output" => "array",
    ];
}
