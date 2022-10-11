<?php

namespace App\Http\Requests\Office\Account;

use Illuminate\Foundation\Http\FormRequest;

class GetAccountNote extends FormRequest {
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
            "filters.account" => "required|uuid|exists:soundblock_accounts,account_uuid",
        ]);
    }
}
