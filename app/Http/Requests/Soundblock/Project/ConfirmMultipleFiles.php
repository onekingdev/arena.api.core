<?php

namespace App\Http\Requests\Soundblock\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Soundblock\Collection\TrackVolumeNumber;

class ConfirmMultipleFiles extends FormRequest {
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
            "project"                               => "required|uuid|exists:soundblock_projects,project_uuid",
            "collection_comment"                    => "required|string",
            "files"                                 => "required|array|min:1",
            "files.*.is_zip"                        => "required|boolean",
            "files.*.file_name"                     => "required|string",
            "files.*.file_title"                    => "required_if:files.*.is_zip,0|string",
            "files.*.track_number"                  => "integer|not_in:0",
            "files.*.preview_start"                 => "integer",
            "files.*.preview_stop"                  => "integer|gt:preview_start",
            "files.*.file_path"                     => "required_if:files.*.is_zip,0|string|max:255",

            "files.*.file_category"                 => "required_if:files.*.is_zip,0|string|file_category",
            "files.*.track_artist"                  => "sometimes|string|max:255",
            "files.*.track_version"                 => "sometimes|nullable|string|max:255",
            "files.*.copyright_name"                => "required_if:files.*.file_category,music|string|max:255",
            "files.*.copyright_year"                => "required_if:files.*.file_category,music|numeric|digits:4",
            "files.*.recording_location"            => "required_with:files.*.recording_year|string|max:255",
            "files.*.recording_year"                => "required_with:files.*.recording_location|nullable|numeric|digits:4",
            "files.*.track_language"                => "required_if:files.*.file_category,music|string|exists:soundblock_data_languages,data_uuid",
            "files.*.track_language_vocals"         => "sometimes|nullable|string|max:255|exists:soundblock_data_languages,data_uuid",
            "files.*.track_volume_number"           => ["required_if:files.*.file_category,music", "integer", "min:1", new TrackVolumeNumber($this->all())],
            "files.*.track_release_date"            => "required_if:files.*.file_category,music|date",
            "files.*.country_recording"             => "sometimes|nullable|string|max:255",
            "files.*.country_commissioning"         => "sometimes|nullable|string|max:255",
            "files.*.rights_holder"                 => "sometimes|nullable|string|max:255",
            "files.*.rights_owner"                  => "sometimes|nullable|string|max:255",
            "files.*.rights_contract"               => "sometimes|nullable|date",
            "files.*.track_notes"                   => "sometimes|nullable|string",
            "files.*.track_lyrics"                  => "sometimes|nullable|string",
            "files.*.flag_track_explicit"           => "required_if:files.*.file_category,music|boolean",
            "files.*.flag_track_instrumental"       => "required_if:files.*.file_category,music|boolean",
            "files.*.flag_allow_preorder"           => "required_if:files.*.file_category,music|boolean",
            "files.*.flag_allow_preorder_preview"   => "required_if:files.*.file_category,music|boolean",
            "files.*.artists"                       => "required_if:files.*.file_category,music|array",
            "files.*.artists.*.artist"              => "required_with:files.*.artists|string",
            "files.*.artists.*.type"                => "required_with:files.*.artists|string|in:primary,featuring",
            "files.*.contributors.*.type"           => "sometimes|nullable|string|exists:soundblock_data_contributors,data_uuid",
            "files.*.contributors.*.contributor"    => "sometimes|nullable|string",
            "files.*.publishers"                    => "sometimes|array",
            "files.*.publishers.*.publisher"        => "required_with:files.*.publishers|string|exists:soundblock_artists_publisher,publisher_uuid",
            "files.*.genre_primary"                 => "required_if:files.*.file_category,music|string|exists:soundblock_data_genres,data_uuid",
            "files.*.genre_secondary"               => "required_if:files.*.file_category,music|string|exists:soundblock_data_genres,data_uuid",

            "files.*.track.file_uuid"               => "uuid",
            "files.*.track.org_file_sortby"         => "string",
            "files.*.zip_content"                   => "required_if:files.*.is_zip,1|array",
            "files.*.zip_content.*.file_category"   => "sometimes|string",
            "files.*.zip_content.*.file_name"       => "required_with:files.*.zip_content|string",
            "files.*.zip_content.*.file_title"      => "required_with:files.*.zip_content|string",
            "files.*.zip_content.*.org_file_sortby" => "required_with:files.*.zip_content|string",

            "files.*.zip_content.*.track_artist"                  => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.track_version"                 => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.copyright_name"                => "required_if:files.*.zip_content.*.file_category,music|string|max:255",
            "files.*.zip_content.*.copyright_year"                => "required_if:files.*.zip_content.*.file_category,music|numeric|digits:4",
            "files.*.zip_content.*.recording_location"            => "required_with:files.*.zip_content.*.recording_year|nullable|string|max:255",
            "files.*.zip_content.*.recording_year"                => "required_with:files.*.zip_content.*.recording_location|nullable|numeric|digits:4",
            "files.*.zip_content.*.track_language"                => "required_if:files.*.zip_content.*.file_category,music|string|exists:soundblock_data_languages,data_uuid",
            "files.*.zip_content.*.track_language_vocals"         => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.track_volume_number"           => ["required_if:files.*.zip_content.*.file_category,music", "integer", "min:1", new TrackVolumeNumber($this->all())],
            "files.*.zip_content.*.track_release_date"            => "required_if:files.*.zip_content.*.file_category,music|date",
            "files.*.zip_content.*.country_recording"             => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.country_commissioning"         => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.rights_holder"                 => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.rights_owner"                  => "sometimes|nullable|string|max:255",
            "files.*.zip_content.*.rights_contract"               => "sometimes|nullable|date",
            "files.*.zip_content.*.track_notes"                   => "sometimes|nullable|string",
            "files.*.zip_content.*.track_lyrics"                  => "sometimes|nullable|string",
            "files.*.zip_content.*.flag_track_explicit"           => "required_if:files.*.zip_content.*.file_category,music|boolean",
            "files.*.zip_content.*.flag_track_instrumental"       => "required_if:files.*.zip_content.*.file_category,music|boolean",
            "files.*.zip_content.*.flag_allow_preorder"           => "required_if:files.*.zip_content.*.file_category,music|boolean",
            "files.*.zip_content.*.flag_allow_preorder_preview"   => "required_if:files.*.zip_content.*.file_category,music|boolean",
            "files.*.zip_content.*.artists"                       => "required_if:files.*.zip_content.*.file_category,music|array",
            "files.*.zip_content.*.artists.*.artist"              => "required_with:files.*.zip_content.*.artists|string",
            "files.*.zip_content.*.artists.*.type"                => "required_with:files.*.zip_content.*.artists|string|in:primary,featuring",
//            "files.*.zip_content.*.contributors"                  => "sometimes|array",
//            "files.*.zip_content.*.contributors.*.type"           => "required_with:files.*.zip_content.*.contributors|string|exists:soundblock_data_contributors,data_uuid",
//            "files.*.zip_content.*.contributors.*.contributor"    => "required_with:files.*.zip_content.*.contributors|string",
            "files.*.zip_content.*.contributors.*.type"           => "sometimes|nullable|string|exists:soundblock_data_contributors,data_uuid",
            "files.*.zip_content.*.contributors.*.contributor"    => "sometimes|nullable|string",
            "files.*.zip_content.*.publishers"                    => "sometimes|array",
            "files.*.zip_content.*.publishers.*.publisher"        => "required_with:files.*.zip_content.*.publishers|string|exists:soundblock_artists_publisher,publisher_uuid",
            "files.*.zip_content.*.genre_primary"                 => "required_if:files.*.zip_content.*.file_category,music|string|exists:soundblock_data_genres,data_uuid",
            "files.*.zip_content.*.genre_secondary"               => "required_if:files.*.zip_content.*.file_category,music|string|exists:soundblock_data_genres,data_uuid",
        ]);
    }
}
