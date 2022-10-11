<?php

namespace App\Http\Requests\Office\Support;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfficeTicket extends FormRequest {
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
        return ([
            "app_uuid"        => "sometimes|required|uuid|exists:core_apps,app_uuid",
            "support"         => "required|support.category",
            "title"           => "required|string",
            "from"            => "required|uuid",
            "from_type"       => "required|string|in:user,group",
            "users"           => "sometimes|required|array",
            "users.*"         => "required_with:users|uuid",
            "groups"          => "sometimes|required|array",
            "groups.*"        => "required_with:groups|uuid",
            "to.*.type"       => "required|string|in:user,group",
            "message"         => "sometimes|required|array",
            "message.text"    => "required_with:message|string",
            "message.files"   => "sometimes|required|array",
            "message.files.*" => "sometimes|required|file",
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'user_uuid.support.user' => 'User UUID is required in Office Project',
        ];
    }
}
