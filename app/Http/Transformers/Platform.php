<?php

namespace App\Http\Transformers;

use App\Traits\StampCache;
use App\Models\Soundblock\Platform as PlatformModel;

class Platform extends BaseTransformer {
    use StampCache;

    public function transform(PlatformModel $objPlatform) {
        $response = [
            "platform_uuid"  => $objPlatform->platform_uuid,
            "platform_name"  => $objPlatform->name,
            "platform_image" => $objPlatform->image,
        ];

        return (array_merge($response, $this->stamp($objPlatform)));
    }
}
