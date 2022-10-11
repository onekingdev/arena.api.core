<?php

namespace App\Models\Support;

use App\Models\Core\App;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends BaseModel {
    use HasFactory;

    protected $table = "support";

    protected $primaryKey = "support_id";

    protected string $uuid = "support_uuid";

    protected $hidden = [
        "support_id", "parent_id", "app_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function app() {
        return ($this->belongsTo(App::class, "app_id", "app_id"));
    }

    public function parent() {
        return ($this->belongsTo(Support::class, "parent_id", "support_id"));
    }

    public function children() {
        return ($this->hasMany(Support::class, "support_id", "parent_id"));
    }
}
