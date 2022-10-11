<?php

namespace App\Http\Requests\Office\Project;

use Illuminate\Foundation\Http\FormRequest;

class CreateMember extends FormRequest {
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
            "user_uuid"                      => "required_without_all:first_name,last_name,user_auth_email|uuid",
            "first_name"                     => "required_without:user_uuid|string",
            "last_name"                      => "required_without:user_uuid|string",
            "user_auth_email"                => "required_without:user_uuid|email",
            "user_role_id"                   => "required|string",
            "team"                           => "required|uuid",
            "permissions"                    => "required|array|min:1",
            "permissions.*.permission_name"  => "required|string",
            "permissions.*.permission_value" => "required|integer|in:0,1",
        ];
    }
}
