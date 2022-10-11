<?php

namespace App\Http\Requests\Soundblock\Platforms;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Soundblock\Platforms\PlatformCategory;

class Platform extends FormRequest {
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
            "project"    => "sometimes|required|uuid|exists:soundblock_projects,project_uuid",
            "collection" => "sometimes|required|uuid|exists:soundblock_collections,collection_uuid",
            "category"   => ["sometimes", "required", new PlatformCategory()],
        ];
    }
}
