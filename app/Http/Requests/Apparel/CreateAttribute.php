<?php

namespace App\Http\Requests\Apparel;

use Illuminate\Foundation\Http\FormRequest;

class CreateAttribute extends FormRequest {
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
            "category_uuid"  => "required|string|max:255|exists:merch_apparel_categories,category_uuid",
            "attribute_name" => "required|string|max:255",
            "attribute_type" => "required|string|max:255",
        ];
    }
}
