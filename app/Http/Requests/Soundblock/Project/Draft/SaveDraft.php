<?php

namespace App\Http\Requests\Soundblock\Project\Draft;

use Illuminate\Foundation\Http\FormRequest;

class SaveDraft extends FormRequest {
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
            "step"                       => "required|integer|min:1|max:3",
            "draft"                      => "uuid|nullable",
            "account"                    => "sometimes|uuid|exists:soundblock_accounts,account_uuid",
            "project_title"              => "sometimes|string|max:255",
            "project_date"               => "sometimes|date",
            "artwork"                    => "sometimes|required|string",
            "format_id"                  => "sometimes|uuid|exists:soundblock_data_projects_formats,data_uuid",
            "project_label"              => "sometimes|nullable|string",
            "project_draft"              => "sometimes|string",
            "project_upc"                => "sometimes|nullable|unique:soundblock_projects,project_upc",
            "artists"                    => "sometimes|array",
            "artists.*.artist"           => "sometimes|string",
            "artists.*.type"             => "sometimes|string|in:primary,featuring",
            "project_artist"             => "sometimes|string|max:255",
            "project_title_release"      => "sometimes|string|max:255",
            "project_volumes"            => "sometimes|integer",
            "project_recording_location" => "sometimes|string|max:255",
            "project_recording_year"     => "sometimes|nullable|numeric|digits:4",
            "project_copyright_name"     => "sometimes|string|max:255",
            "project_copyright_year"     => "sometimes|nullable|numeric|digits:4",
            "flag_project_compilation"   => "sometimes|boolean",
            "flag_project_explicit"      => "sometimes|boolean",
            "project_language"           => "sometimes|string",
            "genre_primary"              => "sometimes|string|exists:soundblock_data_genres,data_uuid",
            "genre_secondary"            => "sometimes|string|exists:soundblock_data_genres,data_uuid",
        ]);
    }
}
