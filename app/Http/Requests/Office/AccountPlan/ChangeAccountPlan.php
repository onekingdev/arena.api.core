<?php

namespace App\Http\Requests\Office\AccountPlan;

use Illuminate\Foundation\Http\FormRequest;

class ChangeAccountPlan extends FormRequest {
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
            "account_plan_type" => "required|string|max:255|exists:soundblock_data_plans_types,data_uuid",
        ];
    }
}
