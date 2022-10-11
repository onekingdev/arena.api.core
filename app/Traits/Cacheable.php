<?php

namespace App\Traits;

use App\Facades\Cache\AppCache;
use App\Http\Resources\Common\BaseCollection;

trait Cacheable {
    public function sendCacheResponse($response, ?string $tag = null) {
        if ($response instanceof BaseCollection) {
            AppCache::setCache($response->toResponse(request())->getData(true), null, $tag);
        }

        if ($response instanceof \Illuminate\Http\Response) {
            AppCache::setCache($response->getOriginalContent(), null, $tag);
        }

        return $response;
    }
}