<?php

namespace App\Http\Requests\Office\Account;

use Illuminate\Foundation\Http\FormRequest;

class UploadAccountNote extends FormRequest {
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
            "account" => "required|uuid|exists:soundblock_accounts,account_uuid",
            "file"    => "required|file|mimes:txt,doc,docx,pdf,jpg,jpeg,png,tiff",
        ]);
    }
}
