<?php

namespace App\Http\Requests\Soundblock\Project\Team;

use Illuminate\Foundation\Http\FormRequest;

class AddTeamMember extends FormRequest {
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
            "user_uuid"                      => "required_without_all:first_name,last_name,user_auth_email|uuid|exists:users,user_uuid",
            "first_name"                     => "required_without:user_uuid|string",
            "last_name"                      => "required_without:user_uuid|string",
            "user_auth_email"                => "required_without:user_uuid|email",
            "user_role_id"                   => "required|uuid|exists:soundblock_data_projects_roles,data_uuid",
            "team"                           => "required|uuid",
            "permissions"                    => "sometimes|array",
            "permissions.*.permission_name"  => "required_with:permissions|string",
            "permissions.*.permission_value" => "required_with:permissions|integer|in:0,1",
        ]);
    }
}
