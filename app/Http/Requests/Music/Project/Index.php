<?php

namespace App\Http\Requests\Music\Project;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Office\Music\FlagHide as FlagHideRule;

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
            "per_page"             => "sometimes|required|integer",
            "genres"               => "sometimes|required|array",
            "genres.*"             => "required_with:genres|uuid|exists:mysql-music.genres,genre_uuid",
            "moods"                => "sometimes|required|array",
            "moods.*"              => "required_with:genres|uuid|exists:mysql-music.moods,mood_uuid",
            "themes"               => "sometimes|required|array",
            "themes.*"             => "required_with:genres|uuid|exists:mysql-music.themes,theme_uuid",
            "styles"               => "sometimes|required|array",
            "styles.*"             => "required_with:genres|uuid|exists:mysql-music.styles,style_uuid",
            "artist_name"          => "sometimes|required|string",
            "popularity"           => "sometimes|required|string|max:5",
            "has_file"             => "sometimes|required|boolean",
            "rating"               => "sometimes|required|numeric",
            "flag_office_hide"     => ["sometimes", "required", "string", new FlagHideRule],
        ];
    }
}
