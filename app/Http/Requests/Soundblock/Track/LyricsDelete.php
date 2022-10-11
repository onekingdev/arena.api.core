<?php

namespace App\Http\Requests\Soundblock\Track;

use Illuminate\Foundation\Http\FormRequest;

class LyricsDelete extends FormRequest
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
            "lyrics" => "required|uuid|exists:soundblock_tracks_lyrics,lyrics_uuid",
        ];
    }
}
