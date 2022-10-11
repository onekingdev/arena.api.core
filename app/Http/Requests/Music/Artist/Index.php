<?php

namespace App\Http\Requests\Music\Artist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Index extends FormRequest {
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
            "per_page" => "sometimes|required|integer",
            "genres"   => "sometimes|required|array",
            "genres.*" => ["required_with:genres", "uuid", Rule::exists("mysql-music.genres", "genre_uuid")],
            "styles"   => "sometimes|required|array",
            "styles.*" => ["required_with:styles", "uuid", Rule::exists("mysql-music.styles", "style_uuid")],
        ];
    }
}
