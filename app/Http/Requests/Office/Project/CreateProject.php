<?php

namespace App\Http\Requests\Office\Project;

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
        return ([
            "account"                                  => "required|uuid|exists:soundblock_accounts,account_uuid",
            "project_title"                            => "required|max:255",
            "project_date"                             => "required|date",
            "format_id"                                => "required|uuid|exists:soundblock_data_projects_formats,data_uuid",
            "project_artwork"                          => "required|file|mimes:png",
            "project_label"                            => "required|string",
            "project_artist"                           => "required|string|max:255",
            "project_title_release"                    => "sometimes|string|max:255",
            "project_volumes"                          => "required|integer",
            "project_recording_location"               => "sometimes|string|max:255",
            "project_recording_year"                   => "sometimes|date",
            "project_copyright_name"                   => "required|string|max:255",
            "project_copyright_year"                   => "required|string|max:4",
            "flag_project_compilation"                 => "required|boolean",
            "flag_project_explicit"                    => "required|boolean",
            "project_language"                         => "required|string|exists:soundblock_data_languages,data_uuid",
            "genre_primary"                            => "required|string|exists:soundblock_data_genres,data_uuid",
            "genre_secondary"                          => "required|string|exists:soundblock_data_genres,data_uuid",
            "artists"                                  => "required|array",
            "artists.*.artist"                         => "required|string",
            "artists.*.type"                           => "required|string|in:primary,featuring",
            "members"                                  => "sometimes|array",
            "members.*.user_uuid"                      => "required_without_all:members.*.first_name,members.*.last_name,members.*.user_auth_email|uuid",
            "members.*.first_name"                     => "required_without:members.*.user_uuid|string",
            "members.*.last_name"                      => "required_without:members.*.user_uuid|string",
            "members.*.user_auth_email"                => "required_without:members.*.user_uuid|email",
            "members.*.user_role_id"                   => "required|string|max:255|exists:soundblock_data_projects_roles,data_uuid",
            "members.*.permissions"                    => "required|array|min:1",
            "members.*.permissions.*.permission_name"  => "required|string",
            "members.*.permissions.*.permission_value" => "required|integer|in:0,1",
        ]);
    }
}
