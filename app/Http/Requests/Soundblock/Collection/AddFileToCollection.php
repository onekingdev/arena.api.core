<?php

namespace App\Http\Requests\Soundblock\Collection;

use App\Rules\Soundblock\Collection\UploadFile;
use Illuminate\Foundation\Http\FormRequest;

class AddFileToCollection extends FormRequest {
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
            "file"    => "required_without:files|file",
            "files"   => ["required_without:file", "array", new UploadFile()],
            "files.*" => "required_with:files|file",
        ]);
    }
}
