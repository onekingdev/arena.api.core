<?php

namespace App\Support\Files;

use App\Helpers\Filesystem\Filesystem as FS;
use Illuminate\Contracts\Filesystem\Filesystem;

class File {
    /*
     * Flag For Showing File Size In Bytes
     * */
    const SIZE_IN_BYTES = 0;

    /*
     * Flag For Showing File Size In KBytes
     * */
    const SIZE_IN_KB = 1;

    /*
     * Flag For Showing File Size In MBytes
     * */
    const SIZE_IN_MB = 2;

    /*
     * Flag For Showing File Size In GBytes
     * */
    const SIZE_IN_GB = 3;

    /**
     * Filesystem Of The File. Can Be Local Or Cloud(S3, Google Drive, etc)
     *
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * File Name Without Path
     *
     * @var string
     */
    protected string $name;

    /**
     * Path To File
     *
     * @var string
     */
    protected string $directory;

    /**
     * File Extension
     *
     * @var string
     */
    protected string $extension;

    /**
     * File Size In Bytes
     *
     * @var int
     */
    protected int $size;

    /**
     * File Name With Path
     *
     * @var string
     */
    protected string $fullName;

    /**
     * File Name Without Extension
     *
     * @var string
     */
    protected string $basicName;

    /**
     * Flag That Shows That File Was Removed
     *
     * @var bool
     */
    protected bool $isDeleted = false;
    /**
     * @param string $file
     * @param Filesystem $filesystem
     */
    public function __construct(string $file, Filesystem $filesystem) {
        $this->filesystem = $filesystem;

        $this->parseFileInfo($file);
    }

    /**
     * Parsing And Setting To Class Properties File Information
     * - Directory Name
     * - File Extension
     * - File Name
     * - File Size In Bytes
     * - Path With File Name
     *
     * @param $file
     * @return $this
     */
    private function parseFileInfo($file): self {
        $arrFileInfo = pathinfo($file);

        $this->directory = $arrFileInfo["dirname"];
        $this->name = $arrFileInfo["basename"];
        $this->extension = $arrFileInfo["extension"];
        $this->basicName = $arrFileInfo["filename"];
        $this->fullName = $file;

        $this->size = $this->filesystem->size($file);

        return $this;
    }

    /**
     * Making Class Instance From File Path
     *
     * @param $file
     * @param Filesystem $filesystem
     * @return array|static
     * @throws \Exception
     */
    public static function factory($file, Filesystem $filesystem) {
        if (is_array($file)) {
            $arrFiles = [];

            foreach ($file as $fileName) {
                if (is_string($fileName)) {
                    $arrFiles[] = new static($fileName, $filesystem);
                } elseif ($fileName instanceof File) {
                    $arrFiles[] = new static($fileName->fullName, $filesystem);
                }
            }

            return $arrFiles;
        } else if (is_string($file)) {
            return new static($file, $filesystem);
        } else {
            throw new \Exception("Invalid File Parameter.");
        }
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDirectory(): string {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function getExtension(): string {
        return $this->extension;
    }

    /**
     * @return int
     */
    public function getSize(): int {
        return $this->size;
    }

    /**
     * @return string
     */
    public function getFullName(): string {
        return $this->fullName;
    }

    /**
     * @param Filesystem $filesystem
     * @param string|null $path
     * @param string|null $strFileName
     * @return File
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function copyToFilesystem(Filesystem $filesystem, ?string $path = null, ?string $strFileName = null): self {
        if (is_null($strFileName)) {
            $strFileName = $this->name;
        }

        $strMovePath = is_string($path) ? $path . FS::DS . $strFileName : $this->getDirectory() . FS::DS . $strFileName;
        $filesystem->writeStream($strMovePath, $this->filesystem->readStream($this->fullName));

        return new static($strMovePath, $filesystem);
    }

    /**
     * @param Filesystem $filesystem
     * @param string|null $path
     * @param string|null $fileName
     * @return File
     * @throws \Illuminate\Contracts\Filesystem\FileExistsException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function moveToFilesystem(Filesystem $filesystem, ?string $path = null, ?string $fileName = null): self {
        $objCopiedFile = $this->copyToFilesystem($filesystem, $path, $fileName);
        $this->delete();

        return $objCopiedFile;
    }

    public function delete(): self {
        $this->filesystem->delete($this->fullName);
        $this->isDeleted = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getBasicName(): string {
        return $this->basicName;
    }
}