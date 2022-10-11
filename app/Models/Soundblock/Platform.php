<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;

use App\Models\Soundblock\Projects\Deployments\Deployment;
use Illuminate\Support\Str;

class Platform extends BaseModel
{
    //
    protected $table = "soundblock_data_platforms";

    protected $primaryKey = "platform_id";

    protected string $uuid = "platform_uuid";

    protected $guarded = [];

    protected $appends =  ["image"];

    const PLATFORM_IMAGE_EXT_EXCEPTIONS = ["youtube"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "platform_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function deployment()
    {
        return $this->hasMany(Deployment::class, "platform_id", "platform_id");
    }

    public function getImageAttribute() {
        $fileName = Str::slug($this->name, "");

        if (array_search($fileName, self::PLATFORM_IMAGE_EXT_EXCEPTIONS) !== false) {
            $fileName = $fileName . ".png";
        } else {
            $fileName = $fileName . ".svg";
        }

        return cloud_url("soundblock") . "platforms/{$fileName}";
    }
}
