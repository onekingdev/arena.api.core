<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;

class AddPaymentMethod extends FormRequest {
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
            'payment_id' => ['required', 'string', 'regex:/pm_.*/'],
        ];
    }

    public function messages() {
        return [
            'payment_id.regex' => 'Payment ID is not valid',
        ];
    }
}
