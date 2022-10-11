<?php

namespace App\Http\Requests\Soundblock\Collection\File;

use Illuminate\Foundation\Http\FormRequest;

class AddTimecodes extends FormRequest {
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
            "preview_start" => "required|integer",
            "preview_stop"  => "required|integer",
        ];
    }
}
