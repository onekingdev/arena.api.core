<?php

namespace App\Models\Soundblock\Data;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contributor extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_data_contributors";

    protected $primaryKey = "data_id";

    protected string $uuid = "data_uuid";

    protected $hidden = [
        "data_id", "pivot", BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];
}
