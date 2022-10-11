<?php

namespace App\Http\Requests\Soundblock\Profile;

use Client;
use Illuminate\Foundation\Http\FormRequest;

class SetPrimary extends FormRequest {

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
            "type"         => "required|string|in:bank,paypal",
            "bank"         => "required_if:type,bank|uuid|exists:users_accounting_banking,row_uuid",
            "paypal"       => "required_if:type,paypal|uuid|exists:users_accounting_paypal,row_uuid",
            "flag_primary" => "required|boolean",
        ]);
    }

    protected function getValidatorInstance() {
        $v = parent::getValidatorInstance();
        $v->sometimes("user", "required|uuid", function () {
            return (Client::app()->app_name == "office");
        });

        return ($v);
    }
}
