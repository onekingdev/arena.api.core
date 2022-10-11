<?php

namespace App\Http\Requests\Office\Project;

use Illuminate\Foundation\Http\FormRequest;

class GetProjects extends FormRequest {
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
            "per_page"                   => "integer|between:10,100",
            "sort_type"                  => "sometimes|required|string|in:asc,desc",
            "filters[deployment_status]" => "deployment_status",
        ];
    }
}
