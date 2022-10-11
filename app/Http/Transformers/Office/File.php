<?php

namespace App\Http\Transformers\Office;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Files\File as FileModel;

class File extends BaseTransformer
{
    use StampCache;

    public function transform(FileModel $objFile)
    {

        $response = [
            "file_id" => $objFile->file_id,
            "file_uuid" => $objFile->file_uuid,
            "file_name" => $objFile->file_name,
            "file_path" => $objFile->file_path,
            "file_title" => $objFile->file_title,
            "file_category" => $objFile->file_category,
            "file_sortby" => $objFile->file_sortby,
            "file_size" => $objFile->file_size
        ];

        return(array_merge($response, $this->stamp($objFile)));
    }
}
