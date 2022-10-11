<?php

namespace App\Http\Resources\Core\Social;

use Illuminate\Http\Resources\Json\JsonResource;

class Instagram extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function toArray($request) {
        $filePath = config("constant.social.instagram.media_path.cdn");
        $fileExt = config("constant.social.instagram.file_extension");

        return cloud_url("core") . $filePath . $this->photo_uuid . "." . $fileExt;
    }
}
