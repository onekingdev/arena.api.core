<?php

namespace App\Contracts\File\Music;

use App\Models\Music\Core\TranscoderJob;
use App\Support\Files\File;

interface Transcoder {
    public function run(File $objFile, string $strOutput, $presets): array;
    public function updateStatus(string $jobId, string $status): TranscoderJob;
}