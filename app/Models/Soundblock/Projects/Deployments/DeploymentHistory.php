<?php

namespace App\Models\Soundblock\Projects\Deployments;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeploymentHistory extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_projects_deployments_history";

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $guarded = [];

    protected $hidden = [
        "deployment_id", "row_id", "platform_id", "collection_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];
}
