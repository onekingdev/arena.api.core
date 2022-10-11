<?php

namespace App\Models\Soundblock;

use App\Helpers\Filesystem\Soundblock;
use App\Models\BaseModel;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_artists";

    protected $primaryKey = "artist_id";

    protected string $uuid = "artist_uuid";

    protected $guarded = [];

    protected $hidden = [
        "pivot", "artist_id", "account_id", BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function projects() {
        return $this->hasMany(Project::class, "artist_id", "artist_id");
    }

    public function account(){
        return ($this->hasOne(Account::class, "account_id", "account_id"));
    }

    public function tracks(){
        return ($this->belongsToMany(Track::class, "soundblock_tracks_artists", "artist_id", "track_id", "artist_id", "track_id"));
    }

    public function getAvatarUrlAttribute(){
        if ($this->avatar_name) {
            return (cloud_url("soundblock") . Soundblock::artists_avatar_path($this));
        } else {
            return null;
        }
    }
}
