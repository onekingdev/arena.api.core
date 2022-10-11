<?php

namespace App\Models\Soundblock\Data;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlansType extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_data_plans_types";

    protected $primaryKey = "data_id";

    protected string $uuid = "data_uuid";

    protected $hidden = [
        "data_id", "plan_version", "plan_level", BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];
}
