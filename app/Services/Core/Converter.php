<?php

namespace App\Services\Core;

use App\Contracts\Core\Converter as ConverterContract;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

class Converter implements ConverterContract {
    const IMAGE_FUNCTIONS = [
        IMAGETYPE_BMP  => "imagebmp",
        IMAGETYPE_GIF  => "imagegif",
        IMAGETYPE_JPEG => "imagejpeg",
        IMAGETYPE_PNG  => "imagepng",
        IMAGETYPE_WBMP => "imagewbmp",
        IMAGETYPE_WEBP => "imagewebp",
        IMAGETYPE_XBM  => "imagexbm",
    ];

    /**
     * @param string $filePath
     * @return string
     * @throws \Exception
     */
    public function convertImageToPng(string $filePath): string {
        return $this->convertImage($filePath, IMAGETYPE_PNG);
    }

    /**
     * @param string $filePath
     * @param int $format
     * @return string
     * @throws \Exception
     */
    private function convertImage(string $filePath, int $format): string {
        if (!isset(self::IMAGE_FUNCTIONS[$format])) {
            throw new \Exception("Unsupported Convert Format.");
        }

        $fileContent = file_get_contents($filePath);

        try{
            $objImage = imagecreatefromstring($fileContent);
        } catch (\ErrorException $exception) {
            throw new ExtensionFileException("Invalid Image Format.", 400);
        }

        $strTmpFilePath = tempnam(null, null);

        if ($strTmpFilePath === false) {
            throw new \Exception("Can Not Create New File.", 500);
        }

        if (!function_exists(self::IMAGE_FUNCTIONS[$format])) {
            throw new \Exception("Convert Function Doesn't Exists", 500);
        }

        if (call_user_func(self::IMAGE_FUNCTIONS[$format], $objImage, $strTmpFilePath) === false) {
            throw new \Exception("Convert Image Have Been Failed.", 500);
        }

        return $strTmpFilePath;
    }
}