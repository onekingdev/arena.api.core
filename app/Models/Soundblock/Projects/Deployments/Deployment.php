<?php

namespace App\Models\Soundblock\Projects\Deployments;

use App\Models\BaseModel;
use App\Models\Soundblock\Ledger;
use App\Models\Soundblock\Platform;
use App\Models\Soundblock\Collections\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deployment extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_projects_deployments";

    protected $primaryKey = "deployment_id";

    protected string $uuid = "deployment_uuid";

    protected $guarded = [];

    protected $casts = [
        "flag_latest_collection" => "boolean",
        "flag_latest_distribution" => "boolean"
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "deployment_id", "project_id", "platform_id", "collection_id", "ledger_id", "flag_notify",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT, BaseModel::DELETED_AT, BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY,
    ];

    public $metaData = [
        "filters" => [
            "projects" => [
                "relation" => "project",
                "relation_table" => "soundblock_projects",
                "column" => "project_uuid"
            ],
            "accounts" => [
                "relation" => [
                    "project",
                    "account"
                ],
                "relation_table" => "soundblock_accounts",
                "column" => "account_uuid"
            ],
            "platforms" => [
                "column" => "platform_uuid"
            ],
            "status" => [
                "column" => "deployment_status"
            ],
            "notify_admin" => [
                "column" => "flag_notify_admin"
            ],
            "notify_user" => [
                "column" => "flag_notify_user"
            ],
            "latest_collection" => [
                "column" => "flag_latest_collection"
            ],
            "latest_distribution" => [
                "column" => "flag_latest_distribution"
            ],
        ],
        "search" => [],
        "sort" => [
            "status" => [
                "column" => "deployment_status"
            ],
            "notify_admin" => [
                "column" => "flag_notify_admin"
            ],
            "notify_user" => [
                "column" => "flag_notify_user"
            ],
            "latest_collection" => [
                "column" => "flag_latest_collection"
            ],
            "latest_distribution" => [
                "column" => "flag_latest_distribution"
            ],
            "project" => [
                "relation_table" => "soundblock_projects",
                "column" => "project_uuid"
            ],
            "created" => [
                "column" => "stamp_created"
            ]
        ]
    ];

    public function platform() {
        return ($this->belongsTo(Platform::class, "platform_id", "platform_id"));
    }

    public function project() {
        return ($this->belongsTo("App\Models\Soundblock\Projects\Project", "project_id", "project_id"));
    }

    public function status() {
        return ($this->hasOne(DeploymentStatus::class, "deployment_id", "deployment_id"));
    }

    public function metadata() {
        return ($this->hasOne(DeploymentMetadata::class, "deployment_id", "deployment_id"));
    }

    public function collection() {
        return ($this->hasOne(Collection::class, "collection_id", "collection_id"));
    }

    public function history() {
        return ($this->hasMany(DeploymentHistory::class, "deployment_id", "deployment_id"));
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }
}
