<?php

namespace App\Services\Common;

use Util;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Office {
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    private \Illuminate\Filesystem\FilesystemAdapter $officeAdapter;

    /**
     */
    public function __construct() {
        $this->initFileSystemAdapter();
    }

    /**
     * @return void
     */
    private function initFileSystemAdapter() {
        if (env("APP_ENV") == "local") {
            $this->officeAdapter = Storage::disk("local");
        } else {
            $this->officeAdapter = bucket_storage("office");
        }
    }

    /**
     * Get the path of file uploaded.
     * @param UploadedFile $file
     * @param string $path
     * @return string|null $path
     */
    public function putFile(UploadedFile $file, string $path): ?string {
        if ($this->officeAdapter->exists($path)) {
            $this->officeAdapter->delete($path);
        }
        $fileName = Util::random_str() . "." . $file->getClientOriginalExtension();

        $this->officeAdapter->putFileAs("public" . DIRECTORY_SEPARATOR . $path, $file, $fileName, "public");

        return (cloud_url("office") . $path . DIRECTORY_SEPARATOR . $fileName);
    }
}
