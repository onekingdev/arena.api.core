<?php

namespace App\Http\Transformers\Common;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Soundblock\File;
use App\Models\Soundblock\Files\FileHistory as FileHistoryModel;
use App\Traits\StampCache;

class FileHistory extends BaseTransformer
{

    use StampCache;
    public function transform(FileHistoryModel $objHistory)
    {
        $response = [
            "row_uuid" => $objHistory->row_uuid,
            "parent_uuid" => $objHistory->parent_uuid,
            "file_uuid" => $objHistory->file_uuid,
            "file_action" => $objHistory->file_action,
            "file_category" => $objHistory->file_category,
            "file_memo" => $objHistory->file_memo,
        ];

        return(array_merge($response, $this->stamp($objHistory)));
    }

    public function includeFile(FileHistory $objHistory)
    {
        return($this->item($objHistory->file, new File()));
    }
}
