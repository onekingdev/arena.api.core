<?php

namespace App\Models\Office;

use App\Models\{Core\Auth\AuthGroup, BaseModel, Users\User};

class Contact extends BaseModel
{
    //
    protected $table = "office_contact";

    protected $primaryKey = "contact_id";

    protected $guarded = [];

    protected $hidden = [
        "contact_id", "user_id",
        BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
        BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    protected string $uuid = "contact_uuid";

    protected $casts = [
        "contact_json" => "array"
    ];

    public $metaData = [
        "filters" => [
            "user_flag_read" => [
                "relation" => "access_users",
                "relation_table" => "office_contact_users",
                "column" => "flag_read"
            ],
            "user_flag_archive" => [
                "relation" => "access_users",
                "relation_table" => "office_contact_users",
                "column" => "flag_archive"
            ],
            "user_flag_delete" => [
                "relation" => "access_users",
                "relation_table" => "office_contact_users",
                "column" => "flag_delete"
            ],
            "group_flag_read" => [
                "relation" => "access_groups",
                "relation_table" => "office_contact_groups",
                "column" => "flag_read"
            ],
            "group_flag_archive" => [
                "relation" => "access_groups",
                "relation_table" => "office_contact_groups",
                "column" => "flag_archive"
            ],
            "group_flag_delete" => [
                "relation" => "access_groups",
                "relation_table" => "office_contact_groups",
                "column" => "flag_delete"
            ],
        ],
        "search" => [
//            "name_first" => [
//                "column" => "contact_name_first"
//            ],
//            "name_last" => [
//                "column" => "contact_name_last"
//            ],
//            "business" => [
//                "column" => "contact_business"
//            ],
//            "subject" => [
//                "column" => "contact_subject"
//            ],
//            "email" => [
//                "column" => "contact_email"
//            ],
//            "phone" => [
//                "column" => "contact_phone"
//            ],
        ],
        "sort" => [
            "user_flag_read" => [
                "relation" => "access_users",
                "relation_table" => "office_contact_users",
                "column" => "flag_read"
            ],
            "user_flag_archive" => [
                "relation" => "access_users",
                "relation_table" => "office_contact_users",
                "column" => "flag_archive"
            ],
            "user_flag_delete" => [
                "relation" => "access_users",
                "relation_table" => "office_contact_users",
                "column" => "flag_delete"
            ],
            "group_flag_read" => [
                "relation" => "access_groups",
                "relation_table" => "office_contact_groups",
                "column" => "flag_read"
            ],
            "group_flag_archive" => [
                "relation" => "access_groups",
                "relation_table" => "office_contact_groups",
                "column" => "flag_archive"
            ],
            "group_flag_delete" => [
                "relation" => "access_groups",
                "relation_table" => "office_contact_groups",
                "column" => "flag_delete"
            ],
        ],
    ];

    public function user()
    {
        return ($this->hasOne(User::class, "user_id", "user_id"));
    }

    public function access_users()
    {
        return ($this->belongsToMany(User::class, "office_contact_users", "contact_id", "user_id", "contact_id", "user_id")
            ->whereNull("office_contact_users." . BaseModel::STAMP_DELETED)
            ->withPivot("contact_uuid", "user_uuid", "flag_read", "flag_archive", "flag_delete")
            ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function access_groups()
    {
        return ($this->belongsToMany(AuthGroup::class, "office_contact_groups", "contact_id", "group_id", "contact_id", "group_id")
            ->whereNull("office_contact_groups." . BaseModel::STAMP_DELETED)
            ->withPivot("contact_uuid", "group_uuid")
            ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function setPropertiesAttribute($value)
    {
        $properties = [];

        foreach ($value as $array_item) {
            if (!is_null($array_item["key"])) {
                $properties[] = $array_item;
            }
        }

        $this->attributes["properties"] = json_encode($properties);
    }
}
