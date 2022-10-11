<?php

namespace App\Http\Requests\Soundblock\Artist;

use Illuminate\Foundation\Http\FormRequest;

class GetArtistPublisher extends FormRequest
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
            "account" => "required|uuid|exists:soundblock_accounts,account_uuid",
            "publisher" => "sometimes|uuid"
        ];
    }
}
