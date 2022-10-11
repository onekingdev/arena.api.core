<?php

namespace App\Services\Cache;

use App\Contracts\Cache\Cache as CacheContract;
use Illuminate\Support\Facades\Cache as CacheFacade;

class Cache implements CacheContract {
    /**
     * @var ?string
     */
    private $endpoint;

    /**
     * @var ?array
     */
    private $requestBody;

    /**
     * @var ?string
     */
    private $className;

    /**
     * @var ?string
     */
    private $methodName;
    /**
     * @var ?string
     */
    private $queryString;

    /**
     * @var string
     * */
    private $cacheKey;

    private $requiredFields = ["className", "methodName", "endpoint", "queryString"];


    public function setClassOptions(string $className, string $methodName) {
        $this->className = $className;
        $this->methodName = $methodName;
    }

    /**
     * @param string $endpoint
     * @param array $requestBody
     */
    public function setRequestOptions(string $endpoint, array $requestBody) {
        $this->endpoint = $endpoint;
        $this->requestBody = $requestBody;
    }

    public function setQueryString(string $queryString) {
        $this->queryString = $queryString;
    }

    /**
     * @param string|null $key
     * @param string|null $tag
     * @return bool
     * @throws \Exception
     */
    public function isCached(?string $key = null, ?string $tag = null): bool {
        return CacheFacade::has($key ?? $this->cacheKey ?? $this->generateName());
    }

    /**
     * @param string|null $key
     * @param string|null $tag
     * @return mixed
     * @throws \Exception
     */
    public function getCache(?string $key = null, ?string $tag = null) {
        return CacheFacade::get($key ?? $this->cacheKey ?? $this->generateName());
    }

    /**
     * @param $cacheData
     * @param string|null $key
     * @param string|null $tag
     * @throws \Exception
     */
    public function setCache($cacheData, ?string $key = null, ?string $tag = null) {
        $strKey = $key ?? $this->cacheKey ?? $this->generateName();

        if (is_string($tag)) {
            CacheFacade::tags($tag)->put($strKey, $cacheData);
        } else {
            CacheFacade::put($strKey, $cacheData);
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function generateName(): string {
        foreach ($this->requiredFields as $field) {
            if (is_null($this->{$field})) {
                throw new \Exception("$field property hasn't provided.");
            }
        }

        $name = $this->className . "." . $this->methodName . "." . md5($this->endpoint) . "." . md5($this->queryString);

        if (!empty($this->requestBody)) {
            $name .= "." . md5(json_encode($this->requestBody));

            if (isset($this->requestBody["page"])) {
                $name .= "." . $this->requestBody["page"];
            }
        }

        return $name;
    }

    public function setCacheKey(string $key) {
        $this->cacheKey = $key;
    }

    public function getCacheKey() {
        return $this->cacheKey;
    }

    public function flushCacheByTag(string $tag) {
        CacheFacade::tags($tag)->flush();
    }
}