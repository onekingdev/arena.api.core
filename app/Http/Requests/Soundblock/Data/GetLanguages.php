<?php

namespace App\Http\Requests\Soundblock\Data;

use Illuminate\Foundation\Http\FormRequest;

class GetLanguages extends FormRequest
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
            "per_page" => "sometimes|integer|between:10,100",
            "lang_name" => "sometimes|string|max:255"
        ];
    }
}
