<?php

namespace App\Models\Core;

use App\Models\Users\User;
use App\Models\Core\Auth\AuthModel;
use App\Models\BaseModel;
use App\Models\Users\UserCorrespondence;

/**
 * @property integer $app_id
 */
class App extends BaseModel {
    protected $primaryKey = "app_id";

    protected string $uuid = "app_uuid";

    protected $table = "core_apps";

    protected $hidden = [
        "app_id", "pivot", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function auth() {
        return ($this->hasMany(AuthModel::class, "app_id", "app_id"));
    }

    public function users() {
        return ($this->belongsToMany(User::class, "users_auth_apps", "app_id", "user_id", "app_id", "user_id")
                     ->withPivot(BaseModel::STAMP_VISITED, BaseModel::VISITED_AT, BaseModel::STAMP_VISITED_BY)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function correspondences() {
        return ($this->hasMany(UserCorrespondence::class, "app_id", "app_id"));
    }

    public function structs() {
        return $this->hasMany(AppsStruct::class, "app_id", "app_id");
    }

    public function correspondence(){
        return $this->hasMany(Correspondence::class, "app_id", "app_id");
    }

    public function structures() {
        return $this->hasMany(AppsStruct::class, "app_id", "app_id");
    }
}
