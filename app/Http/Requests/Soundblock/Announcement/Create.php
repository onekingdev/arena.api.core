<?php

namespace App\Http\Requests\Soundblock\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
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
            "announcement_title"   => "required|string|max:255",
            "announcement_message" => "required|string",
            "flag_email"           => "sometimes|boolean",
            "flag_homepage"        => "sometimes|boolean",
            "flag_projectspage"    => "sometimes|boolean",
        ];
    }
}
