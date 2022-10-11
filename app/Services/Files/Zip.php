<?php

namespace App\Services\Files;

use ZipArchive;
use App\Support\Files\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Helpers\Filesystem\Filesystem as FS;
use App\Contracts\File\Zip as ZipContract;
use League\Flysystem\UnreadableFileException;
use Illuminate\Contracts\Filesystem\Filesystem;

class Zip implements ZipContract {
    /**
     * @var Filesystem
     */
    private Filesystem $objStorage;
    /**
     * @var Filesystem
     */
    private Filesystem $objLocalStorage;
    /**
     * Zip constructor.
     * @param Filesystem $objStorage
     * @param Filesystem $objLocalStorage
     */
    public function __construct(Filesystem $objStorage, Filesystem $objLocalStorage) {
        $this->objStorage = $objStorage;
        $this->objLocalStorage = $objLocalStorage;
    }

    /**
     * @param $file
     * @param callable|null $filter
     * @param string|null $extractToCloud
     * @param array $arrFileNames
     * @return File[]
     * @throws UnreadableFileException
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function unzip($file, ?callable $filter = null, ?string $extractToCloud = null, array $arrFileNames = []) {
        if (is_string($file)) {
            if (file_exists($file)) {
                $strFilePath = $file;
            } elseif ($this->objStorage->exists($file)) {
                $readStream = $this->objStorage->readStream($file);
                $writeStream = $this->objLocalStorage->writeStream($file, $readStream);
                $strFilePath = $this->objLocalStorage->path($file);

                if (!$writeStream) {
                    throw new \Exception("Local Copy Wasn't Created.");
                }
            } else {
                throw new \Exception("File Not Found.");
            }
        } elseif ($file instanceof UploadedFile) {
            $strFilePath = $file->getPathname();
        } else {
            throw new \Exception("Invalid File Param.");
        }

        $objZipArchive = new ZipArchive();

        if ($objZipArchive->open($strFilePath) !== true) {
            throw new UnreadableFileException();
        }

        $strExtractTo = Str::uuid();

        $this->objLocalStorage->makeDirectory($strExtractTo);
        $objZipArchive->extractTo($this->objLocalStorage->path($strExtractTo));
        $objZipArchive->close();

        if ($this->objLocalStorage->exists($strExtractTo . FS::DS . FS::MACOSX_DIR)) {
            $this->objLocalStorage->deleteDirectory($strExtractTo . FS::DS . FS::MACOSX_DIR);
        }

        $arrFiles = File::factory($this->objLocalStorage->allFiles($strExtractTo), $this->objLocalStorage);

        if (is_callable($filter)) {
            $arrFiles = call_user_func($filter, $arrFiles);
        }

        $arrCloudFiles = [];

        /** @var File $objFile*/
        foreach ($arrFiles as $objFile) {
            $strFileName = null;
            info($objFile->getName());
            if (isset($arrFileNames[$objFile->getName()])) {
                info("123");
                $strFileName = $arrFileNames[$objFile->getName()] . "." . $objFile->getExtension();
            }

            $arrCloudFiles[] = $objFile->moveToFilesystem($this->objStorage, $extractToCloud, $strFileName);
        }

        $this->objLocalStorage->deleteDirectory($strExtractTo);

        return $arrCloudFiles;
    }
}