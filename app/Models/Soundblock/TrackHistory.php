<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use App\Traits\StampAttribute;
use App\Models\Casts\StampCast;

class TrackHistory extends BaseModel {
    use StampAttribute;

    protected $table = "soundblock_tracks_history";

    protected $primaryKey = "history_id";

    protected string $uuid = "history_uuid";

    protected $guarded = [];

    protected $hidden = [
        "history_id", "track_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::CREATED_AT
    ];

    protected $casts = [
        BaseModel::STAMP_CREATED_BY => StampCast::class,
        BaseModel::STAMP_UPDATED_BY => StampCast::class,
    ];
}
