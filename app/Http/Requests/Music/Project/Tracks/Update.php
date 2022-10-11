<?php

namespace App\Http\Requests\Music\Project\Tracks;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
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
            "disc_number"  => "sometimes|integer",
            "track_name"   => "sometimes|string|max:255",
            "url_allmusic" => "sometimes|string",
            "url_amazon"   => "sometimes|string",
            "url_spotify"  => "sometimes|string",
            "composers"    => "sometimes|array",
            "composers.*"  => "required_with:composers|uuid",
            "features"     => "sometimes|array",
            "features.*"   => "required_with:features|uuid",
            "performers"   => "sometimes|array",
            "performers.*" => "required_with:performers|uuid",
            "genres"       => "sometimes|array",
            "genres.*"     => "required_with:genres|uuid",
            "moods"        => "sometimes|array",
            "moods.*"      => "required_with:moods|uuid",
            "styles"       => "sometimes|array",
            "styles.*"     => "required_with:styles|uuid",
            "themes"       => "sometimes|array",
            "themes.*"     => "required_with:themes|uuid",
        ];
    }
}
