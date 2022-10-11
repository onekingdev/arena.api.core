<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppStruct extends FormRequest {
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
            "app_name"      => "required|string|max:255",
            "parent_uuid"   => "sometimes|string",
            "struct_prefix" => "required|string|max:255",
            "content"       => "sometimes|array",
            "params"        => "sometimes|array",
            "queryBuilder"  => "sometimes|array",
        ];
    }
}
