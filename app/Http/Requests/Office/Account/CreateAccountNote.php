<?php

namespace App\Http\Requests\Office\Account;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountNote extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return (true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return ([
            "account"       => "required|uuid|exists:soundblock_accounts,account_uuid",
            "account_notes" => "required|string",
            "files"         => "array|min:1",
            "files.*"       => "file|mimes:png,jpg,tiff,bmp,pdf,doc,docx,txt|required",
        ]);
    }
}
