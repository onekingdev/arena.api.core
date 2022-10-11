<?php

namespace App\Http\Requests\Soundblock\Project\Team;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMembers extends FormRequest {
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
            "users"   => "required|array",
            "users.*" => ["required", "uuid", "exists:users,user_uuid"],
        ];
    }
}
