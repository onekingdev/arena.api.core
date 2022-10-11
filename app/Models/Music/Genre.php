<?php

namespace App\Models\Music;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends BaseModel
{
    use HasFactory;

    protected $connection = "mysql-music";

    protected string $uuid = "genre_uuid";

    protected $hidden = [
        "genre_id", "pivot", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];
}
