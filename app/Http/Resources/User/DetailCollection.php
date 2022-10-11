<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Common\BaseCollection;

class DetailCollection extends BaseCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->setStatusData();
        return ["data" => DetailResource::collection($this->collection)];
    }
}
