<?php

namespace App\Http\Requests\Office\Correspondence;

use Illuminate\Foundation\Http\FormRequest;

class ResponseCorrespondence extends FormRequest {
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
            "text"          => "required|string",
            "attachments"   => "sometimes|array",
            "attachments.*" => "required_with:attachments|file|max:10240",
        ]);
    }
}
