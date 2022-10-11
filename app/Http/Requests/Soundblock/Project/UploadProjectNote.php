<?php

namespace App\Http\Requests\Soundblock\Project;

use Illuminate\Foundation\Http\FormRequest;

class UploadProjectNote extends FormRequest {
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
            "project" => "required|uuid|exists:soundblock_projects,project_uuid",
            "file"    => "required|file|mimes:txt,doc,docx,pdf,jpg,jpeg,png,tiff",
        ]);
    }
}