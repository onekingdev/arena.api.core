<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUp extends FormRequest {
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
        $arrValidateData = [
            "name_first"    => "required|string|max:999",
            "email"         => ["required", "string", "email", "max:255"],
            "user_password" => "required|string|confirmed|max:99",
        ];

        if (strpos(strtolower($this->header("X-API-HOST")), "soundblock")) {
            $arrValidateData["phone_number"] = "required|numeric";
            $arrValidateData["phone_type"]   = "required|string|phone_type";
        }

        return $arrValidateData;
    }
}
