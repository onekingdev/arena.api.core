<?php

namespace App\Http\Requests\Office\Project\Deployment;

use Illuminate\Foundation\Http\FormRequest;

class GetAllDeployments extends FormRequest {
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
            "date_to"          => "sometimes|date",
            "date_from"        => "sometimes|date",
            "per_page"         => "sometimes|integer|between:10,100",
            "user_uuids"       => "sometimes|array",
            "user_uuids.*"     => "required_with:user_uuids|uuid|exists:users,user_uuid",
        ];
    }
}
