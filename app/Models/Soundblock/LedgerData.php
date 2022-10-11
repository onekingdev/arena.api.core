<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use App\Models\Casts\StampCast;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LedgerData extends BaseModel
{
    use SoftDeletes, HasFactory;

    protected $table = "soundblock_ledger_data";

    protected $primaryKey = "data_id";

    protected string $uuid = "data_uuid";

    protected $guarded = [];

    protected $casts = [
        "data_json" => "array",
        BaseModel::STAMP_CREATED_BY => StampCast::class,
        BaseModel::STAMP_UPDATED_BY => StampCast::class,
    ];

    protected $hidden = [
        "data_id", "ledger_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];
}
