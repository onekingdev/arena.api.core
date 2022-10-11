<?php

namespace App\Models\Soundblock\Projects;

use App\Models\BaseModel;
use App\Models\Soundblock\Artist as ArtistModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artists extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_projects_artists";

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $guarded = [];

    protected $hidden = [
        "project_id", "row_id", "artist_id", BaseModel::CREATED_AT, BaseModel::UPDATED_AT, BaseModel::DELETED_AT,
        BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function artist(){
        return ($this->hasOne(ArtistModel::class, "artist_id", "artist_id"));
    }

    public function project(){
        return ($this->hasOne(ProjectModel::class, "project_id", "project_id"));
    }
}
