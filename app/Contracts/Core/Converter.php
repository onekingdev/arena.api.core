<?php

namespace App\Contracts\Core;

interface Converter {
    public function convertImageToPng(string $filePath): string;
}