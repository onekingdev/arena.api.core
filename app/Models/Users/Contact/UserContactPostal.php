<?php

namespace App\Models\Users\Contact;

use App\Models\BaseModel;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContactPostal extends BaseModel {
    use SoftDeletes;

    protected $table = "users_contact_postal";

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", "user_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];

    protected $appends = [
        "postal_uuid",
    ];

    protected $guarded = [];

    public function user() {
        return ($this->belongsTo(User::class, "user_id", "user_id"));
    }

    public function getPostalUuidAttribute() {
        return ($this->row_uuid);
    }
}
