<?php

namespace App\Models\Music\Project;

use App\Events\Office\Music\Projects\CreatedDraft;
use App\Models\BaseModel;
use App\Models\Casts\DraftVersionJsonCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectDraftVersion extends BaseModel
{
    use HasFactory;

    protected $casts = [
        "draft_json" => DraftVersionJsonCast::class,
    ];

    protected $table = "projects_drafts_versions";

    protected $connection = "mysql-music";

    protected $primaryKey = "version_id";

    protected string $uuid = "version_uuid";

    protected $hidden = [
        "version_id", "draft_id", "draft_id",
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    protected $dispatchesEvents = [
        'created' => CreatedDraft::class,
    ];

    public function draft() {
        return $this->belongsTo(ProjectDraft::class, "draft_id", "draft_id");
    }
}
