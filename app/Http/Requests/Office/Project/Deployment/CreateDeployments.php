<?php

namespace App\Http\Requests\Office\Project\Deployment;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeployments extends FormRequest {
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
            "deployments"            => "required|array|min:1",
            "deployments.*.project"  => "required|uuid|exists:soundblock_projects,project_uuid",
            "deployments.*.platform" => "required|uuid|exists:soundblock_data_platforms,platform_uuid",
        ]);
    }
}
