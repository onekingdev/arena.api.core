<?php

namespace App\Helpers\Filesystem;

abstract class Filesystem {
    const DS = DIRECTORY_SEPARATOR;

    const WAV = "wav";

    const MACOSX_DIR = "__MACOSX";

    public static function platforms_path(?string $strFileName = null) {
        $strPath = "/public/platforms";

        if (is_string($strFileName)) {
            $strPath .= "/{$strFileName}";
        }

        return $strPath;
    }
}