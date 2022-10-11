<?php

namespace App\Http\Requests\Office\AccountPlan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRenewalDay extends FormRequest {
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
            "new_plan_date" => "required|date_format:Y-m-d",
        ];
    }
}
