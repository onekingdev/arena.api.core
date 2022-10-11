<?php

namespace App\Services\Core;

use App\Contracts\Core\Arena as ArenaContract;
use Illuminate\Support\Facades\Storage;

class Arena implements ArenaContract {

    const ALLOWED_ENV = ["prod", "staging", "develop"];

    const ENV_APPS = [
        "prod"    => "web",
        "staging" => "staging",
        "develop" => "develop",
    ];

    const CONFIG_NAME = "arena";
    /**
     * @var string
     */
    private string $env;

    public function __construct() {
        $this->env = app()->environment(self::ALLOWED_ENV) ? app()->environment() : "develop";
    }

    /**
     * @param string $appName
     * @return string|null
     */
    public function cloudUrl(string $appName): ?string {
        return config()->get($this->getAppVersionKey($appName) . ".aws.cloud.url");
    }

    /**
     * @param string $appName
     * @param string|null $default
     * @return string|null
     */
    public function appUrl(string $appName, ?string $default = null): ?string {
        return config()->get($this->getAppVersionKey($appName) . ".app.url", $default);
    }

    /**
     * @param string $appName
     * @param string $appVarName
     * @param bool $isVersioning
     * @return string|null
     */
    public function appVar(string $appName, string $appVarName, bool $isVersioning = false): ?string {
        $appKay = $isVersioning ? $this->getAppVersionKey($appName) : $this->getAppPrefix($appName);

        return config()->get($appKay . "." . $appVarName);
    }

    public function s3Bucket(string $appName): ?string {
        return config()->get($this->getAppVersionKey($appName) . ".aws.bucket.name");
    }

    /**
     * @param string $appName
     * @return string
     */
    private function getAppVersionKey(string $appName): string {
        return $this->getAppPrefix($appName) . "." . self::ENV_APPS[$this->env];
    }

    /**
     * @param string $appName
     * @return string
     */
    private function getAppPrefix(string $appName): string {
        return self::CONFIG_NAME . "." . rtrim($appName, ".\t\n\r\0\x0B");
    }

    /**
     * @param string $appName
     * @return \Illuminate\Contracts\Filesystem\Cloud
     * @throws \Exception
     */
    public function s3Storage(string $appName): \Illuminate\Contracts\Filesystem\Cloud {
        $strBucketName = $this->s3Bucket($appName);
        if (is_null($strBucketName)) {
            throw new \Exception("Bucket Not Found.", 404);
        }

        return Storage::createS3Driver([
            "driver" => "s3",
            "key" => env("AWS_ACCESS_KEY_ID"),
            "secret" => env("AWS_SECRET_ACCESS_KEY"),
            "region" => env("AWS_DEFAULT_REGION"),
            "bucket" => $strBucketName
        ]);
    }

    public function beanstalkConfig(string $appName, ?string $env = null): ?array {
        if (is_null($env)) {
            $env = $this->env;
        }

        $configPath = "{$this->getAppPrefix($appName)}.$env.aws.eb";

        return config($configPath);
    }
}