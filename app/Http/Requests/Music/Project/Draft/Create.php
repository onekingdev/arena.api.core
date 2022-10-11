<?php

namespace App\Http\Requests\Music\Project\Draft;

use Illuminate\Foundation\Http\FormRequest;

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
            "artist"                 => "required|uuid|exists:mysql-music.artists,artist_uuid",
            "type"                   => "required|string",
            "date"                   => "required|date",
            "name"                   => "required|string",
            "label"                  => "required|string",
            "url_allmusic"           => "sometimes|required|string|url",
            "url_amazon"             => "sometimes|required|string|url",
            "url_itunes"             => "sometimes|required|string|url",
            "url_spotify"            => "sometimes|required|string|url",
            "tracks"                 => "sometimes|required|array",
            "tracks.*.name"          => "required_with:tracks|string",
            "tracks.*.original_name" => "required_with:tracks|string",
            "tracks.*.disc_number"   => "required_with:tracks|integer",
            "tracks.*.track_number"  => "required_with:tracks|integer",
            "tracks.*.url_amazon"    => "sometimes|required_with:tracks|url",
            "tracks.*.url_spotify"   => "sometimes|required_with:tracks|url",
            "tracks.*.url_allmusic"  => "sometimes|required_with:tracks|url",
            "tracks.*.composers"     => "required_with:tracks|array",
            "tracks.*.composers.*"   => "required_with:tracks|string|uuid|exists:mysql-music.artists,artist_uuid",
            "tracks.*.performers"    => "required_with:tracks|array",
            "tracks.*.performers.*"  => "required_with:tracks|string|uuid|exists:mysql-music.artists,artist_uuid",
            "tracks.*.features"      => "sometimes|required_with:tracks|array",
            "tracks.*.features.*"    => "sometimes|required_with:tracks|string|uuid|exists:mysql-music.artists,artist_uuid",
            "file"                   => "sometimes|required|file|mimes:zip",
            "genres"                 => "sometimes|required|array",
            "genres.*"               => "required_with:genres|string|uuid|exists:mysql-music.genres,genre_uuid",
            "moods"                  => "sometimes|required|array",
            "moods.*"                => "required_with:moods|string|uuid|exists:mysql-music.moods,mood_uuid",
            "styles"                 => "sometimes|required|array",
            "styles.*"               => "required_with:styles|string|uuid|exists:mysql-music.styles,style_uuid",
            "themes"                 => "sometimes|required|array",
            "themes.*"               => "required_with:themes|string|uuid|exists:mysql-music.themes,theme_uuid",
        ];
    }
}
