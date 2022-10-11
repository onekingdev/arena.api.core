<?php

namespace App\Http\Requests\Office\Project\Deployment;

use Illuminate\Foundation\Http\FormRequest;

class GetDeployments extends FormRequest {
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
            "per_page" => "integer|between:10,100",
        ]);
    }
}
