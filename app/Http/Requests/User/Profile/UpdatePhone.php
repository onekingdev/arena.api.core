<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Client;

class UpdatePhone extends FormRequest {
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
            "old_phone_number" => "required|string",
            "phone_number"     => "string|required_without:flag_primary",
            "flag_primary"     => "boolean",
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
