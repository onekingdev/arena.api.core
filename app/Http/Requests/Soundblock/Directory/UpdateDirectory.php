<?php

namespace App\Http\Requests\Soundblock\Directory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDirectory extends FormRequest {

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
            "file_category"      => "required|string",
            "project"            => "required|uuid|exists:soundblock_projects,project_uuid",
            "collection_comment" => "required|string",
            "directory_sortby"   => "required|string",
            "new_directory_name" => "required|string|different:directory_name",
            "new_directory_path" => "required|string",
        ]);
    }
}
