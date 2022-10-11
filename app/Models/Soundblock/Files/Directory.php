<?php

namespace App\Models\Soundblock\Files;

use App\Models\BaseModel;
use App\Models\Soundblock\Collections\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Directory extends BaseModel
{
    use SoftDeletes, HasFactory;

    protected $table = "soundblock_files_directories";

    protected $primaryKey = "directory_id";

    protected string $uuid = "directory_uuid";

    protected $hidden = [
        "directory_id"
    ];

    protected $guarded = [];

    public function files()
    {
        return($this->hasMany(File::class, "directory_id", "directory_id"));
    }

    public function collections()
    {
        return($this->belongsToMany(Collection::class, "soundblock_collections_directories", "directory_id", "collection_id", "directory_id", "collection_id")
                ->whereNull("soundblock_collections_directories." . BaseModel::STAMP_DELETED)
                ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }
}
