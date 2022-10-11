<?php

namespace App\Http\Resources\Soundblock;

use App\Http\Resources\Common\BaseCollection;

class InvitesCollection extends BaseCollection {
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        $this->setStatusData();

        return ["data" => InviteResource::collection($this->collection)];
    }
}
