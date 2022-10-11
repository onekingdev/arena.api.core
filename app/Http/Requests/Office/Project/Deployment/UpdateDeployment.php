<?php

namespace App\Http\Requests\Office\Project\Deployment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeployment extends FormRequest {
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
        return [
            "deployment"        => "sometimes|string|uuid",
            "deployments"       => "sometimes|array",
            "deployments.*"     => "sometimes|string|uuid",
            "deployment_status" => "required|deployment_status",
        ];
    }
}
