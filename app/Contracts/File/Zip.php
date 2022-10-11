<?php

namespace App\Contracts\File;

interface Zip {
    public function unzip($file, ?callable $filter = null, ?string $extractToCloud = null, array $arrFileNames = []);
}