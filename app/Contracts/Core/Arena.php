<?php

namespace App\Contracts\Core;

interface Arena {
    public function cloudUrl(string $appName): ?string;

    public function appUrl(string $appName, ?string $default = null): ?string;

    public function appVar(string $appName, string $appVarName, bool $isVersioning = false): ?string;

    public function s3Bucket(string $appName): ?string;

    public function s3Storage(string $appName);

    public function beanstalkConfig(string $appName, ?string $env = null): ?array;
}