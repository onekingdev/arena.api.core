<?php

namespace App\Http\Requests\Soundblock\Track;

use App\Rules\Soundblock\Collection\TrackVolumeNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTrack extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "project"      => "required|uuid|exists:soundblock_projects,project_uuid",
            "file_uuid"    => "required|uuid",

            "file_title"                    => "sometimes|string|max:255",
            "track_artist"                  => "sometimes|nullable|string|max:255",
            "track_version"                 => "sometimes|nullable|string|max:255",
            "copyright_name"                => "sometimes|string|max:255",
            "copyright_year"                => "sometimes|string|max:4",
            "recording_location"            => "sometimes|nullable|string|max:255",
            "recording_year"                => "sometimes|nullable|string|max:4",
            "track_language"                => "sometimes|string|exists:soundblock_data_languages,data_uuid",
            "track_language_vocals"         => "sometimes|nullable|string|max:255",
            "track_volume_number"           => ["sometimes", "nullable", "integer", "min:1", new TrackVolumeNumber($this->all())],
            "track_release_date"            => "sometimes|date",
            "country_recording"             => "sometimes|nullable|string|max:255",
            "country_commissioning"         => "sometimes|nullable|string|max:255",
            "rights_holder"                 => "sometimes|nullable|string|max:255",
            "rights_owner"                  => "sometimes|nullable|string|max:255",
            "rights_contract"               => "sometimes|nullable|date",
            "flag_track_explicit"           => "sometimes|boolean",
            "flag_track_instrumental"       => "sometimes|boolean",
            "flag_allow_preorder"           => "sometimes|boolean",
            "flag_allow_preorder_preview"   => "sometimes|boolean",
            "preview_start"                 => "sometimes|integer",
            "preview_stop"                  => "sometimes|integer|gt:preview_start",
            "genre_primary"                 => "sometimes|string|exists:soundblock_data_genres,data_uuid",
            "genre_secondary"               => "sometimes|string|exists:soundblock_data_genres,data_uuid",
            "artists"                       => "sometimes|array",
            "artists.*.artist"              => "required_with:artists|string",
            "artists.*.type"                => "required_with:artists|string|in:primary,featuring",
            "contributors"                  => "sometimes|nullable|array",
            "contributors.*.type"           => "required_with:contributors|string|exists:soundblock_data_contributors,data_uuid",
            "contributors.*.contributor"    => "required_with:contributors|string",
            "publishers"                    => "sometimes|nullable|array",
            "publishers.*.publisher"        => "required_with:publishers|string|exists:soundblock_artists_publisher,publisher_uuid",
        ];
    }
}
