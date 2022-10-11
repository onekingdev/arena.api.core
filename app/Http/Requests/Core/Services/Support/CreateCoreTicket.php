<?php

namespace App\Http\Requests\Core\Services\Support;

use Illuminate\Foundation\Http\FormRequest;

class CreateCoreTicket extends FormRequest {
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
        return ([
            "support"         => "required|support.category",
            "title"           => "required|string",
            "message"         => "sometimes|required|array",
            "message.text"    => "required_with:message|string",
            "message.files"   => "sometimes|required|array",
            "message.files.*" => "sometimes|required|file",
        ]);
    }
}
