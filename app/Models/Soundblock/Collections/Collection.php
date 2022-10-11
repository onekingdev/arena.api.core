<?php

namespace App\Models\Soundblock\Collections;

use App\Models\BaseModel;
use App\Models\Soundblock\Files\File;
use App\Models\Soundblock\Files\Directory;
use App\Models\Soundblock\Files\FileMerch;
use App\Models\Soundblock\Track;
use App\Models\Soundblock\Files\FileOther;
use App\Models\Soundblock\Files\FileVideo;
use App\Models\Soundblock\Ledger;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Soundblock\Pivot\FileHistoryPivot;
use App\Models\Soundblock\Projects\Deployments\Deployment;

class Collection extends BaseModel {
    use SoftDeletes, HasFactory;

    protected $table = "soundblock_collections";

    protected $primaryKey = "collection_id";

    protected string $uuid = "collection_uuid";

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "collection_id", "project_id", "project", "ledger_id",
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];

    public function tracks() {
        return ($this->belongsToMany(Track::class, "soundblock_collections_files", "collection_id", "file_id", "collection_id", "file_id")
                     ->whereNull("soundblock_collections_files." . BaseModel::STAMP_DELETED)
                     ->orderby("track_number", "asc")
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function videos() {
        return ($this->belongsToMany(FileVideo::class, "soundblock_collections_files", "collection_id", "file_id", "collection_id", "file_id")
                     ->whereNull("soundblock_collections_files." . BaseModel::STAMP_DELETED)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function merches() {
        return ($this->belongsToMany(FileMerch::class, "soundblock_collections_files", "collection_id", "file_id", "collection_id", "file_id")
                     ->whereNull("soundblock_collections_files." . BaseModel::STAMP_DELETED)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function others() {
        return ($this->belongsToMany(FileOther::class, "soundblock_collections_files", "collection_id", "file_id", "collection_id", "file_id")
                     ->whereNull("soundblock_collections_files." . BaseModel::STAMP_DELETED)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function project() {
        return ($this->belongsTo(Project::class, "project_id", "project_id"));
    }

    public function collectionFilesHistory() {
        return ($this->belongsToMany(File::class, "soundblock_files_history", "collection_id", "file_id", "collection_id", "file_id")
                     ->using(FileHistoryPivot::class)
                     ->whereNull("soundblock_files_history." . BaseModel::STAMP_DELETED)
                     ->withPivot("collection_uuid", "file_uuid", "file_action", "file_category", "file_memo")
                     ->orderBy(BaseModel::STAMP_CREATED, "asc")
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function history() {
        return ($this->hasOne(CollectionHistory::class, "collection_id", "collection_id"));
    }

    public function deployments() {
        return ($this->hasMany(Deployment::class, "collection_id", "collection_id"));
    }

    public function countFiles() {
        return ($this->files()->count());
    }

    public function files() {
        return ($this->belongsToMany(File::class, "soundblock_collections_files", "collection_id", "file_id", "collection_id", "file_id")
                     ->withPivot("file_uuid", "collection_uuid")
                     ->whereNull("soundblock_collections_files." . BaseModel::STAMP_DELETED)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }

    public function countDirectories() {
        return ($this->directories()->count());
    }

    public function directories() {
        return ($this->belongsToMany(Directory::class, "soundblock_collections_directories", "collection_id", "directory_id", "collection_id", "directory_id")
                     ->whereNull("soundblock_collections_directories." . BaseModel::STAMP_DELETED)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function size() {
        return ($this->files()->sum("file_size"));
    }
}
