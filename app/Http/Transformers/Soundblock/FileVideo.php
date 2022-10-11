<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Files\FileVideo as FileVideoModel;

class FileVideo extends BaseTransformer
{

    use StampCache;

    public function transform(FileVideoModel $objFileVideo)
    {

        $response = [
            "track" => $objFileVideo->track? $objFileVideo->track->file_title : null,
            "file_isrc" => $objFileVideo->file_isrc,
        ];

        if ($objFileVideo->file)
        {
            $objFile = $objFileVideo->file;
            array_merge($response, $objFile->toArray());
        }
        $response = array_merge($response, $this->stamp($objFileVideo));
        return($response);
    }

    public function includeTrack(FileVideoModel $objFileVideo)
    {
        if (!is_null($objFileVideo->track))
            return($this->item($objFileVideo->track->music, new Track));
    }
}
