<?php

namespace App\Services\Soundblock;

use App\Models\Soundblock\Collections\Collection;

class Directory {

    /**
     * @param $objCollection
     * @param string $directory_uuid
     * @return array
     */
    public function prepareDownloadDirectoryFiles(Collection $objCollection, string $directory_uuid){
        $files = collect();
        $objMainDir = $objCollection->directories()->where("soundblock_files_directories.directory_uuid", $directory_uuid)->first();
        $objDirectories = $objCollection->directories()->where("directory_sortby", "like", "%{$objMainDir->directory_sortby}%")->get();

        foreach ($objDirectories as $objDirectory) {
            $files = $files->merge($objDirectory->files);
        }

        return (["files" => $files->unique("file_uuid")->toArray()]);
    }
}
