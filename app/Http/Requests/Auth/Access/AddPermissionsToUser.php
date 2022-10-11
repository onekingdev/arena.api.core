<?php

namespace App\Http\Requests\Auth\Access;

use Illuminate\Foundation\Http\FormRequest;

class AddPermissionsToUser extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return (true);
    }

    public function rules() {
        return ([
            "user"          => "required|uuid|exists:users,user_uuid",
            "group"         => "required|uuid|exists:core_auth_groups,group_uuid",
            "permissions"   => "required|array|min:1",
            "permissions.*" => "required|uuid|exists:core_auth_permissions,permission_uuid",
        ]);
    }
}
