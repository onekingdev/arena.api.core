<?php

namespace App\Http\Requests\Soundblock\Track;

use Illuminate\Foundation\Http\FormRequest;

class ArtistsStore extends FormRequest
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
            "file" => "required|uuid|exists:soundblock_files,file_uuid",
            "type" => "required|string|in:primary,featuring",
            "artist" => "required|uuid|exists:soundblock_artists,artist_uuid"
        ];
    }
}
