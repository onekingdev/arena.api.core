<?php

namespace App\Models\Core\Social;

use Util;
use App\Models\BaseModel;

class Instagram extends BaseModel
{
    protected $table = "core_social_instagram";

    public $timestamps = false;

    const UUID = "photo_uuid";

    protected $guarded = [];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->{self::UUID} = Util::uuid();
        });
    }
}
