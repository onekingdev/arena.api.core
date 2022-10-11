<?php

namespace App\Http\Requests\Soundblock\Collection;

use App\Rules\Soundblock\Collection\TrackVolumeNumber;
use Illuminate\Foundation\Http\FormRequest;

class EditFilesInCollection extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return (true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules() {
        return ([
            "project"                 => "required|uuid|exists:soundblock_projects,project_uuid",
            "files"                   => "required|array|min:1",
            "files.*.file_uuid"       => "required|uuid",
            "files.*.file_name"       => "required|string",
            "files.*.file_title"      => "required|string",
            "files.*.file_category"   => "required|string|file_category",
            "files.*.meta.track_uuid" => "nullable|uuid",
            "files.*.meta.track_number" => "nullable|integer|min:1",

            "files.*.track_artist"                  => "sometimes|string|max:255",
            "files.*.track_version"                 => "sometimes|string|max:255",
            "files.*.copyright_name"                => "sometimes|string|max:255",
            "files.*.copyright_year"                => "sometimes|string|max:4",
            "files.*.recording_location"            => "sometimes|string|max:255",
            "files.*.recording_year"                => "sometimes|string|max:4",
            "files.*.track_language"                => "sometimes|string|exists:soundblock_data_languages,data_uuid",
            "files.*.track_language_vocals"         => "required_if:files.*.flag_track_instrumental,0|string|max:255",
            "files.*.track_volume_number"           => ["sometimes", "integer", "min:1", new TrackVolumeNumber($this->all())],
            "files.*.track_release_date"            => "sometimes|date",
            "files.*.country_recording"             => "sometimes|string|max:255",
            "files.*.country_commissioning"         => "sometimes|string|max:255",
            "files.*.rights_holder"                 => "sometimes|string|max:255",
            "files.*.rights_owner"                  => "sometimes|string|max:255",
            "files.*.rights_contract"               => "sometimes|date",
            "files.*.flag_track_explicit"           => "sometimes|boolean",
            "files.*.flag_track_instrumental"       => "sometimes|boolean",
            "files.*.flag_allow_preorder"           => "sometimes|boolean",
            "files.*.flag_allow_preorder_preview"   => "sometimes|boolean",
            "files.*.artists"                       => "sometimes|array",
            "files.*.artists.*.artist"              => "required_with:files.*.artists|string",
            "files.*.artists.*.type"                => "required_with:files.*.artists|string|in:primary,featuring",
            "files.*.genre_primary"                 => "sometimes|string|exists:soundblock_data_genres,data_uuid",
            "files.*.genre_secondary"               => "sometimes|string|exists:soundblock_data_genres,data_uuid",
            "files.*.contributors"                  => "sometimes|array",
            "files.*.contributors.*.type"           => "required_with:files.*.contributors|string|exists:soundblock_data_contributors,data_uuid",
            "files.*.contributors.*.contributor"    => "required_with:files.*.contributors|string|max:255",
            "files.*.publishers"                    => "sometimes|array",
            "files.*.publishers.*.publisher"        => "required_with:files.*.publishers|string|exists:soundblock_artists_publisher,publisher_uuid",
        ]);
    }
}
