<?php

namespace App\Http\Requests\Soundblock\Reports;

use Illuminate\Foundation\Http\FormRequest;

class Report extends FormRequest {
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
            "date_start" => "required|string|date|date_format:Y-m-d",
            "date_end"   => "required|string|date|date_format:Y-m-d|after_or_equal:date_start",
        ];
    }
}
