<?php

namespace App\Http\Requests\Music\Artist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Update extends FormRequest {
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
            "artist_name"            => "sometimes|required|string",
            "artist_active"          => "sometimes|required|string",
            "artist_born"            => "sometimes|required|string",
            "url_allmusic"           => "sometimes|required|url",
            "url_amazon"             => "sometimes|required|url",
            "url_itunes"             => "sometimes|required|url",
            "url_lastfm"             => "sometimes|required|url",
            "url_spotify"            => "sometimes|required|url",
            "url_wikipedia"          => "sometimes|required|url",
            "genres"                 => "sometimes|required|array",
            "genres.*"               => ["sometimes", "required_with:genres", "uuid", Rule::exists("mysql-music.genres", "genre_uuid")],
            "styles"                 => "sometimes|required|array",
            "styles.*"               => ["sometimes", "required_with:styles", "uuid", Rule::exists("mysql-music.styles", "style_uuid")],
            "themes"                 => "sometimes|required|array",
            "themes.*"               => ["sometimes", "required_with:themes", "uuid", Rule::exists("mysql-music.themes", "theme_uuid")],
            "moods"                  => "sometimes|required|array",
            "moods.*"                => ["sometimes", "required_with:moods", "uuid", Rule::exists("mysql-music.moods", "mood_uuid")],
            "members"                => "sometimes|required|array",
            "members.*"              => "sometimes|required_with:members|string"
        ];
    }
}
