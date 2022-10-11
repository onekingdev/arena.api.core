<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtistPublisher extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_artists_publisher";

    protected $primaryKey = "publisher_id";

    protected string $uuid = "publisher_uuid";

    protected $guarded = [];

    protected $hidden = [
        "pivot", "artist_id", "account_id", "publisher_id", BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];
}
