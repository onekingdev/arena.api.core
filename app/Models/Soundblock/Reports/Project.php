<?php

namespace App\Models\Soundblock\Reports;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_reports_projects";

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", "project_id", "track_id", "platform_id",
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];
}
