<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class AddItemToShoppingCart extends FormRequest {
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
            "quantity"   => "required|integer",
            "model_uuid" => "required|string|max:255",
        ];
    }
}
