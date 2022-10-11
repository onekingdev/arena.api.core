<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Models\Soundblock\Files\File;
use App\Http\Transformers\BaseTransformer;

class OnlyFile extends BaseTransformer
{

    use StampCache;

    public function transform(File $objFile)
    {
        $response = [
            "file_uuid" => $objFile->file_uuid,
            "file_name" => $objFile->file_name,
            "file_path" => $objFile->file_path,
            "file_title" => $objFile->file_title,
            "file_category" => $objFile->file_category,
            "file_sortby" => $objFile->file_sortby,
            "file_size" => $objFile->file_size,
            "track_duration" => $objFile->track_duration,
            "track_isrc" => $objFile->track_isrc,
            "track_artist" => $objFile->track_artist,
            "track_version" => $objFile->track_version,
            "copyright_name" => $objFile->copyright_name,
            "copyright_year" => $objFile->copyright_year,
            "recording_location" => $objFile->recording_location,
            "recording_year" => $objFile->recording_year,
            "language" => $objFile->track->language->data_language,
            "language_vocals" => optional($objFile->track->languageVocals)->data_language,
            "track_volume_number" => $objFile->track_volume_number,
            "track_release_date" => $objFile->track_release_date,
            "country_recording" => $objFile->country_recording,
            "country_commissioning" => $objFile->country_commissioning,
            "rights_holder" => $objFile->rights_holder,
            "rights_owner" => $objFile->rights_owner,
            "rights_contract" => $objFile->rights_contract,
            "flag_track_explicit" => $objFile->flag_track_explicit,
            "flag_track_instrumental" => $objFile->flag_track_instrumental,
            "flag_allow_preorder" => $objFile->flag_allow_preorder,
            "flag_allow_preorder_preview" => $objFile->flag_allow_preorder_preview,
            "preview_start" => $objFile->preview_start,
            "preview_stop" => $objFile->preview_stop,
            "genre_primary" => $objFile->track->primaryGenre->data_genre,
            "genre_secondary" => $objFile->track->secondaryGenre->data_genre,
            "artists" => $objFile->track->artists,
            "contributors" => $objFile->track->contributors,
            "meta"  => $objFile->meta,
            File::STAMP_CREATED => $objFile->{File::STAMP_CREATED},
            File::STAMP_CREATED_BY => $objFile->{File::STAMP_CREATED_BY},
            File::STAMP_UPDATED => $objFile->{File::STAMP_UPDATED},
            File::STAMP_UPDATED_BY => $objFile->{File::STAMP_UPDATED_BY}
        ];

        if ($objFile->pivot)
        {
            if ($objFile->pivot->file_action && $objFile->pivot->file_category)
            {
                $response["file_action"] = $objFile->pivot->file_action;
                $response["file_category"] = $objFile->pivot->file_category;
                $response["file_memo"] = $objFile->pivot->file_memo;
            }
        }

        return($response);
    }

    public function includeMusic(File $objFile)
    {
        return($this->item($objFile->track, new Track));
    }

    public function includeVideo(File $objFile)
    {
        return($this->item($objFile->video, new FileVideo(["track"])));
    }

    public function includeMerch(File $objFile)
    {
        return($this->item($objFile->merch, new FileMerch));
    }

    public function includeOther(File $objFile)
    {
        return($this->item($objFile->other, new FileOther));
    }
}
