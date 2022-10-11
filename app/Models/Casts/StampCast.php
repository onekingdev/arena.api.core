<?php

namespace App\Models\Casts;

use App\Models\{BaseModel, Users\Contact\UserContactEmail, Users\User};
use App\Traits\StampCache;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class StampCast implements CastsAttributes
{
    use StampCache;

    public function get($model, $key, $value, $attributes)
    {
        if (!is_array($value) && array_search($key ,[BaseModel::STAMP_CREATED_BY, BaseModel::STAMP_UPDATED_BY, UserContactEmail::STAMP_EMAIL_BY, BaseModel::STAMP_DISCOUNT_BY]) !== false) {
            return $this->getStampBy($value);
        } else {
            return($value);
        }
    }

    public function set($model, $key, $value, $attributes)
    {
        if (is_array($value) && isset($value["uuid"])) {
            $value = User::where("user_uuid", $value["uuid"])->value("user_id");
        }

        return [$key => $value];
    }
}
