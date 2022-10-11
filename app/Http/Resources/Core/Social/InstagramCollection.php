<?php

namespace App\Http\Resources\Core\Social;

use App\Http\Resources\Common\BaseCollection;

class InstagramCollection extends BaseCollection {
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request) {
        $this->setStatusData();

        return Instagram::collection($this->collection);
    }
}
