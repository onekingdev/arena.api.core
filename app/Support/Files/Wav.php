<?php

namespace App\Support\Files;

use App\Contracts\File\Music\Transcoder;
use App\Services\Files\Music\Transcoder as TranscoderService;
use App\Helpers\Filesystem\Filesystem as FS;
use Illuminate\Contracts\Filesystem\Filesystem;

class Wav extends File {
    /**
     * Transcoder Service
     *
     * @var Transcoder
     */
    private Transcoder $objTranscoder;

    public function __construct(string $file, Filesystem $filesystem) {
        parent::__construct($file, $filesystem);

        $this->objTranscoder = resolve(Transcoder::class);
    }

    public function transcode(string $strOutput) {
        return $this->objTranscoder->run($this, $strOutput, [TranscoderService::MP3_320K, TranscoderService::MP3_192K,
            TranscoderService::MP3_160K, TranscoderService::MP3_128K]);
    }

    public static function filter(array $arrFiles) {
        $arrFiltered = [];

        /** @var File $objFile */
        foreach ($arrFiles as $objFile) {
            if ($objFile->getExtension() === FS::WAV) {
                $arrFiltered[] = $objFile;
            }
        }

        return $arrFiltered;
    }
}
