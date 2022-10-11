<?php

namespace App\Http\Requests\Soundblock\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAccount extends FormRequest {
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
            "user"              => "required|uuid|exists:users,user_uuid",
            "account_name"      => "required|string",
            "account_plan_type" => ["required", "string", "exists:soundblock_data_plans_types,data_uuid"]
        ]);
    }
}
