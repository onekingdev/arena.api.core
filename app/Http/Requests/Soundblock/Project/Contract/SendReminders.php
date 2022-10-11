<?php

namespace App\Http\Requests\Soundblock\Project\Contract;

use Illuminate\Foundation\Http\FormRequest;

class SendReminders extends FormRequest {
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
            "user_uuid"   => "required_without:invite_uuid|uuid|exists:users,user_uuid",
            "invite_uuid" => "required_without:user_uuid|uuid",
        ];
    }
}
