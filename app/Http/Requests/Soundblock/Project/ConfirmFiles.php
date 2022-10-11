<?php

namespace App\Http\Requests\Soundblock\Project;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmFiles extends FormRequest {
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
            "is_zip"                        => "required|boolean",
            "project"                       => "required|uuid|exists:soundblock_projects,project_uuid",
            "file_name"                     => "required|string",
            "collection_comment"            => "required|string",
            "files"                         => "required|array|min:1",
            "files.*.file_title"            => "required|string",
            "files.*.file_name"             => "required|string",
            "files.*.track_number"            => "integer|not_in:0",
            "files.*.preview_start"         => "date_format:i:s|before:files.*.preview_stop",
            "files.*.preview_stop"          => "date_format:i:s|after:files.*.preview_start",
            "files.*.file_path"             => "sometimes|string|max:255",
            "files.*.org_file_sortby"       => "string|required_if:is_zip,1",
            "files.*.track.file_uuid"       => "uuid",
            "files.*.track.org_file_sortby" => "string",
        ]);
    }
}
