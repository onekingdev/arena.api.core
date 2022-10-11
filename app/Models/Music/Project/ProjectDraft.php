<?php

namespace App\Models\Music\Project;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectDraft extends BaseModel {
    use HasFactory;

    protected $table = "projects_drafts";

    protected $connection = "mysql-music";

    protected $primaryKey = "draft_id";

    protected string $uuid = "draft_uuid";

    protected $hidden = [
        "user_id", "parent_id", "draft_id", "group_id",
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    public function versions() {
        return $this->hasMany(ProjectDraftVersion::class, "draft_id", "draft_id");
    }
}
