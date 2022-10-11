<?php

namespace App\Http\Requests\Music\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Office\Music\FlagHide as FlagHideRule;

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
            "name"                   => "sometimes|required|string",
            "type"                   => "sometimes|required|string",
            "date"                   => "sometimes|required|date",
            "label"                  => "sometimes|required|string",
            "url_allmusic"           => "sometimes|required|string|url",
            "url_amazon"             => "sometimes|required|string|url",
            "url_itunes"             => "sometimes|required|string|url",
            "url_spotify"            => "sometimes|required|string|url",
            "flag_office_hide"       => ["sometimes", "required", "string", new FlagHideRule],
            "flag_office_complete"   => "sometimes|required|boolean",
            "flag_dead"              => "sometimes|required|boolean",
            "artist"                 => "sometimes|required|uuid|exists:mysql-music.artists,artist_uuid",
            "genres"                 => "sometimes|array",
            "genres.*"               => "required_with:genres|uuid",
            "moods"                  => "sometimes|array",
            "moods.*"                => "required_with:moods|uuid",
            "styles"                 => "sometimes|array",
            "styles.*"               => "required_with:styles|uuid",
            "themes"                 => "sometimes|array",
            "themes.*"               => "required_with:themes|uuid",
            "tracks"                 => "required_with:file|array",
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
            "file"                   => "required_with:tracks|file|mimes:zip",
        ];
    }
}
