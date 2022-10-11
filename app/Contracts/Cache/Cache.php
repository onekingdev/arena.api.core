<?php

namespace App\Contracts\Cache;

interface Cache {
    public function setClassOptions(string $className, string $methodName);
    public function setRequestOptions(string $endpoint, array $requestBody);
    public function setQueryString(string $queryString);
    public function setCacheKey(string $key);
    public function getCacheKey();

    public function isCached(?string $key = null, ?string $tag = null): bool;
    public function getCache(?string $key = null, ?string $tag = null);
    public function setCache($cacheData, ?string $key = null, ?string $tag = null);
    public function flushCacheByTag(string $tag);
}