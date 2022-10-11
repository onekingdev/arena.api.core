<?php

namespace App\Http\Transformers\User;

use Util;
use App\Models\Users\User;
use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;

class Avatars extends BaseTransformer {

    use StampCache;

    public function transform(User $objUsers) {
        $response = [
            "user_uuid"  => $objUsers->user_uuid,
            "avatar_url" => Util::avatar_url($objUsers),
        ];

        return ($response);
    }
}
