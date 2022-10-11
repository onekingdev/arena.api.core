<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Client;

class UpdatePostal extends FormRequest {
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
            "postal"         => "required|uuid|exists:users_contact_postal,row_uuid",
            "postal_type"    => "string|postal_type",
            "postal_street"  => "string",
            "postal_city"    => "string",
            "postal_zipcode" => "postal_zipcode",
            "postal_country" => "string",
            "flag_primary"   => "boolean",
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
