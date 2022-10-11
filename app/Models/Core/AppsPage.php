<?php

namespace App\Models\Core;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppsPage extends BaseModel
{
    use HasFactory;

    const UUID = "page_uuid";

    protected $primaryKey = "page_id";

    protected $table = "core_apps_pages";

    protected $guarded = [];

    protected string $uuid = "page_uuid";

    protected $hidden = [
        "page_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];

    protected $casts = [
        "page_json" => "array"
    ];

    public function struct(){
        return $this->belongsTo(AppsStruct::class, "struct_id", "struct_id");
    }
}
