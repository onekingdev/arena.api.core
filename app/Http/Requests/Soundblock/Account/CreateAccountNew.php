<?php

namespace App\Http\Requests\Soundblock\Account;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountNew extends FormRequest {
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
            "account_name" => "required|string",
        ]);
    }
}
