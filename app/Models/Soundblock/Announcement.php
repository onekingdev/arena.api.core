<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_announcements";

    protected $primaryKey = "announcement_id";

    protected string $uuid = "announcement_uuid";

    protected $guarded = [];

    protected $hidden = [
        "announcement_id", BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public $metaData = [
        "filters" => [
            "email" => [
                "column" => "flag_email"
            ],
            "homepage" => [
                "column" => "flag_homepage"
            ],
            "projectspage" => [
                "column" => "flag_projectspage"
            ],
        ],
        "search" => [
            "title" => [
                "column" => "announcement_title"
            ],
        ],
        "sort" => [
            "email" => [
                "column" => "flag_email"
            ],
            "homepage" => [
                "column" => "flag_homepage"
            ],
            "projectspage" => [
                "column" => "flag_projectspage"
            ],
        ],
    ];
}
