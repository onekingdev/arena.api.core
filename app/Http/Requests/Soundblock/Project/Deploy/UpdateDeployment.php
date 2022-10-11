<?php

namespace App\Http\Requests\Soundblock\Project\Deploy;

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
            "status" => ["required", "string", "max:255", "in:takedown,redeploy"],
            "collection" => ["required_if:status,==,redeploy", "uuid"]
        ];
    }
}
