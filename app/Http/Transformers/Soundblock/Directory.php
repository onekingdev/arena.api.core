<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Files\Directory as DirectoryModel;

class Directory extends BaseTransformer
{
    use StampCache;

    public function transform(DirectoryModel $objDir)
    {
        $response = [
            "directory_uuid" => $objDir->directory_uuid,
            "directory_name" => $objDir->directory_name,
            "directory_path" => $objDir->directory_path,
            "directory_sortby" => $objDir->directory_sortby,
        ];

        return(array_merge($response, $this->stamp($objDir)));
    }
}
