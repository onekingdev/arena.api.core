<?php

namespace App\Http\Requests\Office\Contact;

use Illuminate\Foundation\Http\FormRequest;

class GetContactsByAccess extends FormRequest {
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
            "group"         => "uuid|required_without:user|exists:core_auth_groups,group_uuid",
            "user"          => "uuid|required_without:group|exists:users,user_uuid",
            "flag_read"    => "boolean",
            "flag_archive" => "boolean",
            "flag_delete"  => "boolean",
        ]);
    }
}
