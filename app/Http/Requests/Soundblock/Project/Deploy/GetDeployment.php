<?php

namespace App\Http\Requests\Soundblock\Project\Deploy;

use Illuminate\Foundation\Http\FormRequest;

class GetDeployment extends FormRequest {
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
            "per_page" => "required|integer|between:10,100",
        ]);
    }
}
