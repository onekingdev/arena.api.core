<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class CreateCorrespondence extends FormRequest {
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
            "email"         => "required|email",
            "subject"       => "required|string",
            "json"          => "required|string",
            "attachments"   => "sometimes|required|array",
            "attachments.*" => "required_with:attachments|file",
        ];
    }
}
