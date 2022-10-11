<?php

namespace App\Http\Requests\Office\Auth\AuthPermission;

use Illuminate\Foundation\Http\FormRequest;

class CreateAuthPermissiion extends FormRequest {
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
            "permission_name" => "required|string",
            "permission_memo" => "required|string",
        ]);
    }
}
