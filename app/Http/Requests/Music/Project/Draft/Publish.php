<?php

namespace App\Http\Requests\Music\Project\Draft;

use Illuminate\Foundation\Http\FormRequest;

class Publish extends FormRequest {
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
            "version" => "sometimes|required|uuid|exists:mysql-music.projects_drafts_versions,version_uuid",
        ];
    }
}
