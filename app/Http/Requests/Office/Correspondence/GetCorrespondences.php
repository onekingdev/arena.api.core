<?php

namespace App\Http\Requests\Office\Correspondence;

use Illuminate\Foundation\Http\FormRequest;

class GetCorrespondences extends FormRequest {
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
            "per_page"           => "sometimes|int",
            "filters"            => "sometimes|array",
            "filters.date_start" => "sometimes|date",
            "filters.date_end"   => "sometimes|date",
        ]);
    }
}
