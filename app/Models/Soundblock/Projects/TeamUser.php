<?php

namespace App\Models\Soundblock\Projects;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Soundblock\Data\ProjectsRole as ProjectRoleModel;

class TeamUser extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_projects_teams_users";

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $guarded = [];

    protected $hidden = [
        "row_id", "team_id", "user_id", "role_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::STAMP_CREATED_BY, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        "pivot"
    ];

    public function role(){
        return ($this->hasOne(ProjectRoleModel::class, "data_id", "role_id"));
    }
}
