<?php

namespace App\Http\Requests\Soundblock\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProject extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            "title"                      => "sometimes|string|max:255",
            "date"                       => "sometimes|date",
            "artwork"                    => "sometimes|image|dimensions:min_width=1400,min_height=1400|dimensions:ratio=1/1",
            "type"                       => "sometimes|project_type",
            "format_id"                  => "sometimes|uuid|exists:soundblock_data_projects_formats,data_uuid",
            "label"                      => "sometimes|nullable|string",
            "upc"                        => "sometimes|string",
            "artists"                    => "sometimes|nullable|array",
            "artists.*.artist"           => "required_with:artists|string",
            "artists.*.type"             => "required_with:artists|string|in:primary,featuring",
            "project_artist"             => "sometimes|string|max:255",
            "project_title_release"      => "sometimes|nullable|string|max:255",
            "project_volumes"            => "sometimes|integer|min:1",
            "project_recording_location" => "sometimes|nullable|string|max:255",
            "project_recording_year"     => "sometimes|nullable|numeric|digits:4",
            "project_copyright_name"     => "sometimes|string|max:255",
            "project_copyright_year"     => "sometimes|numeric|digits:4",
            "flag_project_compilation"   => "sometimes|boolean",
            "flag_project_explicit"      => "sometimes|boolean",
            "project_language"           => "sometimes|string",
            "genre_primary"              => "sometimes|string|exists:soundblock_data_genres,data_uuid",
            "genre_secondary"            => "sometimes|nullable|string|exists:soundblock_data_genres,data_uuid",
        ];
    }
}
