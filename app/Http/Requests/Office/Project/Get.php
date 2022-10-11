<?php

namespace App\Http\Requests\Office\Project;

use Illuminate\Foundation\Http\FormRequest;

class Get extends FormRequest {

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
            "project"           => "uuid|exists:soundblock_projects,project_uuid",
            "deployment_status" => "string|deployment_status",
        ]);
    }
}
