<?php

namespace App\Http\Requests\Music\Artist;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Create extends FormRequest {
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
            "name"                   => "required|string",
            "active_date"            => "required|string",
            "born"                   => "required|string",
            "allmusic_url"           => "sometimes|required|url",
            "amazon_url"             => "sometimes|required|url",
            "itunes_url"             => "sometimes|required|url",
            "lastfm_url"             => "sometimes|required|url",
            "spotify_url"            => "sometimes|required|url",
            "wikipedia_url"          => "sometimes|required|url",
            "genres"                 => "sometimes|required|array",
            "genres.*"               => ["sometimes", "required", "uuid", Rule::exists("mysql-music.genres", "genre_uuid")],
            "styles"                 => "sometimes|required|array",
            "styles.*"               => ["sometimes", "required", "uuid", Rule::exists("mysql-music.styles", "style_uuid")],
            "themes"                 => "sometimes|required|array",
            "themes.*"               => ["sometimes", "required", "uuid", Rule::exists("mysql-music.themes", "theme_uuid")],
            "moods"                  => "sometimes|required|array",
            "moods.*"                => ["sometimes", "required", "uuid", Rule::exists("mysql-music.moods", "mood_uuid")],
            "members"                => "sometimes|required|array",
            "members.*.member"       => "sometimes|required|string",
            "members.*.url_allmusic" => "sometimes|required|string",
        ];
    }
}
