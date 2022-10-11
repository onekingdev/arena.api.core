<?php

namespace App\Contracts\Core;

interface Sox {
    public function getInfo(string $strFilePath);
    public function convert(string $strFilePath);
}