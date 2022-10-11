<?php

namespace App\Http\Requests\Office\AccountPlan;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountPlan extends FormRequest {
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
            "account_uuid" => "required|uuid|exists:soundblock_accounts,account_uuid",
            "plan_type"    => ["required", "string", "exists:soundblock_data_plans_types,data_uuid"],
        ];
    }
}
