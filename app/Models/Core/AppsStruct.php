<?php

namespace App\Models\Core;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppsStruct extends BaseModel
{
    use HasFactory;

    const UUID = "struct_uuid";

    const JSON_KEYS = [
        "queryBuilder" => "queryBuilder",
        "additionalContent" => "content",
        "queryParams" => "params",
        "queryWhere" => "where",
        "queryModel" => "model",
        "queryRelations" => "relationship",
        "queryColumn" => "column",
        "queryValue" => "value",
        "queryOperator" => "operator"
    ];

    protected $primaryKey = "struct_id";

    protected $table = "core_apps_struct";

    protected $guarded = [];

    protected string $uuid = "struct_uuid";

    protected $hidden = [
        "app_id",
        "struct_id",
        "parent_id",
        "struct_json",
        BaseModel::DELETED_AT,
        BaseModel::CREATED_AT,
        BaseModel::UPDATED_AT,
        BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY,
    ];

    protected $casts = [
        "struct_json" => "array"
    ];

    public function pages() {
        return $this->hasMany(AppsPage::class, "struct_id", "struct_id");
    }

    public function app() {
        return $this->belongsTo(App::class, "app_id", "app_id");
    }

    public function parent(){
        return $this->belongsTo(self::class, "parent_id", "struct_id");
    }
}
