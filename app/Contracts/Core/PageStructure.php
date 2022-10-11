<?php

namespace App\Contracts\Core;

use App\Models\Core\AppsStruct;

interface PageStructure {
    public function getStructures(?string $strAppName = null): array;
    public function createStruct(array $requestData): AppsStruct;
    public function getStructureByPrefix(string $strStructPrefix): AppsStruct;
    public function getStructureByUuid(string $strStructUUID): AppsStruct;

    public function validateParams(string $structureUuid, string $param, string $value): bool;
    public function validateContent(string $structureUuid, string $content): bool;
}