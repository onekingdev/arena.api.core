<?php

namespace App\Http\Requests\Apparel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategories extends FormRequest {
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
            "*.category_uuid"             => "required|string|exists:merch_apparel_categories,category_uuid",
            "*.category_meta_keywords"    => "sometimes|string|max:255",
            "*.category_meta_description" => "sometimes|string",
        ];
    }
}
