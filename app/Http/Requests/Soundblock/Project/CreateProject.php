<?php

namespace App\Http\Requests\Soundblock\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateProject extends FormRequest {

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
        return [
            "account"                    => "required|uuid|exists:soundblock_accounts,account_uuid",
            "project_title"              => "required|string|max:255",
            "project_date"               => "required|date",
            "artwork"                    => "sometimes|required|string",
            "format_id"                  => "required|uuid|exists:soundblock_data_projects_formats,data_uuid",
            "project_label"              => "required|nullable|string",
            "project_draft"              => "sometimes|string",
            "project_upc"                => "sometimes|nullable|unique:soundblock_projects,project_upc",
            "artists"                    => "sometimes|array",
            "artists.*.artist"           => "required_with:artists|string",
            "artists.*.type"             => "required_with:artists|string|in:primary,featuring",
            "project_artist"             => "required|string|max:255",
            "project_title_release"      => "sometimes|string|max:255",
            "project_volumes"            => "required|integer|min:1",
            "project_recording_location" => "sometimes|string|max:255",
            "project_recording_year"     => "sometimes|nullable|numeric|digits:4",
            "project_copyright_name"     => "required|string|max:255",
            "project_copyright_year"     => "required|numeric|digits:4",
            "flag_project_compilation"   => "required|boolean",
            "flag_project_explicit"      => "required|boolean",
            "project_language"           => "required|string",
            "genre_primary"              => "required|string|exists:soundblock_data_genres,data_uuid",
            "genre_secondary"            => "sometimes|string|exists:soundblock_data_genres,data_uuid",
        ];
    }
}
