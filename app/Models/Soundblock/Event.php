<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_events";

    protected $primaryKey = "event_id";

    protected $hidden = [
        "event_id", "user_id", "eventable_type", "eventable_id",
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    protected string $uuid = "event_uuid";

    public function scopeUnprocessed($query) {
        return $query->where("flag_processed", false);
    }
}
