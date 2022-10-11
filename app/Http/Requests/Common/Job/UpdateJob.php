<?php

namespace App\Http\Requests\Common\Job;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJob extends FormRequest {
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
            //
            "job"              => "required|uuid|exists:queue_jobs,job_uuid",
            "flag_silentalert" => "required|boolean|in:0",
        ]);
    }
}
