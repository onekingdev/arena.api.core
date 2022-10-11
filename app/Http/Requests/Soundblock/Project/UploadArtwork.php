<?php

namespace App\Http\Requests\Soundblock\Project;

use Illuminate\Foundation\Http\FormRequest;

class UploadArtwork extends FormRequest {
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
            "artwork" => "required|file|mimes:jpeg,jpg,png,bmp,tiff|dimensions:min_width=1400,min_height=1400|dimensions:ratio=1/1",
        ]);
    }
}
