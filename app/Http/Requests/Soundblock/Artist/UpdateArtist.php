<?php

namespace App\Http\Requests\Soundblock\Artist;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtist extends FormRequest
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
            "account"        => "required|uuid|exists:soundblock_accounts,account_uuid",
            "project_uuid"   => "sometimes|uuid|exists:soundblock_projects,project_uuid",
            "artist"         => "required|uuid",
            "artist_name"    => "required|string",
            "url_apple"      => "sometimes|nullable|string",
            "url_soundcloud" => "sometimes|nullable|string",
            "url_spotify"    => "sometimes|nullable|string",
            "avatar"         => "sometimes|nullable|file|mimes:jpeg,jpg,png,bmp,tiff",
        ];
    }
}
