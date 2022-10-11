<?php

namespace App\Http\Requests\Office\AccountPlan;

use Illuminate\Foundation\Http\FormRequest;

class GetPlans extends FormRequest {
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
            "sort_plan"       => "sometimes|required|in:asc,desc",
            "sort_created_at" => "sometimes|required|in:asc,desc",
        ];
    }
}
