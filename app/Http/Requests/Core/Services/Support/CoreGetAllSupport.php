<?php

namespace App\Http\Requests\Core\Services\Support;

use Illuminate\Foundation\Http\FormRequest;

class CoreGetAllSupport extends FormRequest {
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
            "per_page"              => "sometimes|integer|between:10,100",
            "sort"                  => "sometimes|string|in:asc,desc",
            "sort_app"              => "sometimes|string|in:asc,desc",
            "flag_status"           => "sometimes|string|support.flag_status",
            "sort_flag_status"      => "sometimes|string|in:asc,desc",
            "support_category"      => "sometimes|string|support.category",
            "sort_support_category" => "sometimes|string|in:asc,desc",
            "date_start"            => "sometimes|date",
            "date_end"              => "sometimes|date",
            "users"                 => "sometimes|array",
            "users.*"               => "required_with:users|uuid",
            "groups"                => "sometimes|array",
            "groups.*"              => "required_with:groups|uuid",
        ]);
    }
}
