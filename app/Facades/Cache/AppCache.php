<?php


namespace App\Facades\Cache;

use App\Contracts\Exceptions\Exception;
use Illuminate\Support\Facades\Facade;

/**
 * @method static setRequestOptions(string $endpoint, array $requestBody)
 * @method static setClassOptions(string $className, string $methodName)
 * @method static setQueryString(string $queryString)
 * @method static bool isCached(?string $key = null)
 * @method static getCache(?string $key = null)
 * @method static setCache($cacheData, ?string $key = null, ?string $tag = null)
 * @method static setCacheKey(string $key)
 * @method static getCacheKey()
 * @method static flushCacheByTag(string $tag)
 */
class AppCache extends Facade {
    protected static function getFacadeAccessor() {
        return "app-cache";
    }
}
