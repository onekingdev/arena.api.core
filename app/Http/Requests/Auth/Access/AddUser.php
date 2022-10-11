<?php

namespace App\Http\Requests\Auth\Access;

use Illuminate\Foundation\Http\FormRequest;

class AddUser extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return(true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return([
           "group" => "required|uuid|exists:core_auth_groups,group_uuid",
           "users" => "required|array",
           "users.*" => "required|uuid|exists:users,user_uuid"
        ]);
    }

}
