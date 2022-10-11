<?php

namespace App\Http\Requests\Office\TypeAheads;

use Illuminate\Foundation\Http\FormRequest;

class Project extends FormRequest {
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
            "project" => "sometimes|required|string",
            "artist"  => "sometimes|required|string|uuid",
            "account" => "sometimes|required|string|uuid",
        ];
    }
}
