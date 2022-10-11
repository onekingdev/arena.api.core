<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShoppingCart extends FormRequest {
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
            'payment_method' => ['required', 'string', 'regex:/pm_.*/'],
        ];
    }

    public function messages() {
        return [
            'payment_method.regex' => 'Payment method is not valid',
        ];
    }
}
