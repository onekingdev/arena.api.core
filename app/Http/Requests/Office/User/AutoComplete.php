<?php

namespace App\Http\Requests\Office\User;

use App\Rules\Autocomplete\{UserAutocompleteRelations, UserAutocomplete};
use Illuminate\Foundation\Http\FormRequest;

class AutoComplete extends FormRequest {
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
            "user"             => "required|string",
            "select_fields"    => ["sometimes", "string", new UserAutocomplete()],
            "select_relations" => ["sometimes", "string", new UserAutocompleteRelations($this->all())],
        ]);
    }
}
