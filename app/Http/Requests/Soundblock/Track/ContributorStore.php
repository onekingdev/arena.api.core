<?php

namespace App\Http\Requests\Soundblock\Track;

use Illuminate\Foundation\Http\FormRequest;

class ContributorStore extends FormRequest
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
            "file" => "required|uuid|exists:soundblock_files,file_uuid",
            "type" => "required|uuid|exists:soundblock_data_contributors,data_uuid",
            "contributor" => "required|string|max:255"
        ];
    }
}
