<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use App\Models\Casts\StampCast;
use App\Models\Soundblock\Data\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrackLyrics extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_tracks_lyrics";

    protected $primaryKey = "lyrics_id";

    protected string $uuid = "lyrics_uuid";

    protected $guarded = [];

    protected $hidden = [
        "track_id", "lyrics_id", "language_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    protected $casts = [
        BaseModel::STAMP_CREATED_BY => StampCast::class,
        BaseModel::STAMP_UPDATED_BY => StampCast::class,
    ];

    public function language(){
        return ($this->hasOne(Language::class, "data_id", "language_id"));
    }

    public function track(){
        return ($this->hasOne(Track::class, "track_id", "track_id"));
    }
}
