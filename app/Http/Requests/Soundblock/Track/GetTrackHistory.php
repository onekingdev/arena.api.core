<?php

namespace App\Http\Requests\Soundblock\Track;

use Illuminate\Foundation\Http\FormRequest;

class GetTrackHistory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "project"      => "required|uuid|exists:soundblock_projects,project_uuid",
            "file_uuid"    => "required|uuid|exists:soundblock_files,file_uuid",
        ];
    }
}
