<?php

namespace App\Models\Soundblock\Projects\Deployments;

use App\Models\BaseModel;

class DeploymentMetadata extends BaseModel
{
    //
    protected $table = "soundblock_projects_deployments_metadata";

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $guarded = [];

    protected $hidden = [
        "row_id", "deployment_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY
    ];

    protected $casts = [
        "metadata_json" => "array"
    ];

    public function deployment()
    {
        return($this->belongsTo(Deployment::class, "deployment_id", "deployment_id"));
    }
}
