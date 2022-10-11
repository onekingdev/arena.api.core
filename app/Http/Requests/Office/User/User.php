<?php

namespace App\Http\Requests\Office\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class User extends FormRequest {
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
            "user"        => "uuid|exists:users,user_uuid",
            "per_page"    => "integer|required_without:user",
            "filter_name" => "sometimes|string|max:255",
            "sort_date"   => ["sometimes", "string", Rule::in(["asc", "desc"])],
        ]);
    }

}
