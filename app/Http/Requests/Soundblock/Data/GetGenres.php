<?php

namespace App\Http\Requests\Soundblock\Data;

use Illuminate\Foundation\Http\FormRequest;

class GetGenres extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "flag_primary" => "sometimes|boolean",
            "flag_secondary" => "sometimes|boolean"
        ];
    }
}
