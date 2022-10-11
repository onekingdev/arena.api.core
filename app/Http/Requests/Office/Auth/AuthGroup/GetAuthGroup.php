<?php

namespace App\Http\Requests\Office\Auth\AuthGroup;

use Illuminate\Foundation\Http\FormRequest;

class GetAuthGroup extends FormRequest {
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
            "group" => "required|uuid|exists:core_auth_groups,group_uuid",
        ]);
    }
}
