<?php

namespace App\Models\Soundblock\Projects;

use App\Models\BaseModel;
use App\Models\Soundblock\Accounts\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDraft extends BaseModel
{
    use SoftDeletes;
    use HasFactory;

    protected $primaryKey = "draft_id";

    protected string $uuid = "draft_uuid";

    protected $table = "soundblock_projects_drafts";

    protected $casts = [
        "draft_json" => "array"
    ];

    protected $hidden = [
        "draft_id", "account_id",
        BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY, BaseModel::UPDATED_AT, BaseModel::STAMP_UPDATED_BY,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY
    ];

    protected $guarded = [];

    public function account()
    {
        return($this->belongsTo(Account::class, "account_id", "account_id"));
    }

    public function setPropertiesAttribute($value)
    {
        $properties = [];
        foreach($value as $array_item)
        {
            if (!is_null($array_item["key"]))
            {
                $properties[] = $array_item;
            }
        }
        $this->attributes["properties"] = json_encode($properties);
    }
}
