<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Track as FileTrackModel;

class Track extends BaseTransformer
{

    use StampCache;

    public function transform(FileTrackModel $objFileTrack)
    {

        $response = [
            "track_number" => $objFileTrack->track_number,
            "track_duration" => $objFileTrack->track_duration,
            "track_isrc" => $objFileTrack->track_isrc,
        ];

        if ($objFileTrack->file)
        {
            $objFile = $objFileTrack->file;
            $response = array_merge($response, $objFile->toArray());
        }
        $response = array_merge($response, $this->stamp(($objFileTrack)));

        return($response);
    }

    public function includeFile(FileTrackModel $objFileTrack)
    {
        return($this->item($objFileTrack->file, new File));
    }
}
