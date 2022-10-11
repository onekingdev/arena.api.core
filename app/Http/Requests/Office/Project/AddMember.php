<?php

namespace App\Http\Requests\Office\Project;

use Illuminate\Foundation\Http\FormRequest;

class AddMember extends FormRequest {
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
            "user" => "required|string|max:255|exists:users,user_uuid",
            "user_role_id" => "required|string|max:255|exists:soundblock_data_projects_roles,data_uuid"
        ]);
    }
}
