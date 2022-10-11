<?php

namespace App\Http\Requests\Soundblock\Directory;

use Illuminate\Foundation\Http\FormRequest;

class AddDirectory extends FormRequest {

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
            "project"            => "required|uuid|exists:soundblock_projects,project_uuid",
            "collection_comment" => "required|string",
            "directory_path"     => "required|string",
            "directory_name"     => "required|string",
            "directory_category" => "required|string|in:Merch,Files",
            "parent_directory"   => "sometimes|string|exists:soundblock_files_directories,directory_uuid"
        ]);
    }
}
