<?php

namespace App\Http\Requests\Soundblock\Collection\File;

use Illuminate\Foundation\Http\FormRequest;

class RevertFile extends FormRequest {
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
            "file_category"      => "required|file_category",
            "collection_comment" => "required|string",
            "collection"         => "required|uuid|exists:soundblock_collections,collection_uuid",
            "files"              => "required|array|min:1",
            "files.*.file_uuid"  => "required|uuid|exists:soundblock_files,file_uuid",
        ]);
    }
}
