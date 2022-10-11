<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest {

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
            "user"        => "sometimes|required|uuid|exists:users,user_uuid",
            "name_first"  => "sometimes|nullable|string",
            "name_middle" => "sometimes|nullable|string",
            "name_last"   => "sometimes|nullable|string",
        ]);
    }

}
