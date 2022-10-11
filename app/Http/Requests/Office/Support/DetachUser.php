<?php

namespace App\Http\Requests\Office\Support;

use Illuminate\Foundation\Http\FormRequest;

class DetachUser extends FormRequest {
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
        if (request()->is("office/support/ticket/*/member")) {
            return [
                "user"  => ["string", "required_without:group", "exists:users,user_uuid"],
                "group" => ["string", "required_without:user", "exists:core_auth_groups,group_uuid"],
            ];
        }

        return [
            "users"    => "required_without:groups|array",
            "users.*"  => ["required", "uuid", "exists:users,user_uuid"],
            "groups"   => "required_without:users|array",
            "groups.*" => ["required", "uuid", "exists:core_auth_groups,group_uuid"],
        ];

    }
}
