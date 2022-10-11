<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Core\AppsPages\Params as ParamsRule;
use App\Rules\Core\AppsPages\Content as ContentRule;

class CreatePage extends FormRequest {
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
        return [
            "struct_uuid"                   => "required|string|max:255|exists:App\Models\Core\AppsStruct,struct_uuid",
            "page_url"                      => "required|string|max:255",
            "params"                        => ["required", "array", new ParamsRule($this->request->get("struct_uuid") ?? "")],
            "content.header"                => "required|string",
            "content"                       => ["required", "array", new ContentRule($this->request->get("struct_uuid") ?? "")],
            "meta"                          => "required|array",
            "meta.page_title.default"       => "nullable|max:255",
            "meta.page_title.twitter"       => "nullable|max:255",
            "meta.page_keywords.default"    => "nullable|max:255",
            "meta.page_keywords.twitter"    => "nullable|max:255",
            "meta.page_description.default" => "nullable",
            "meta.page_description.twitter" => "nullable",
            "meta.page_image.default"       => "sometimes|nullable|image",
            "meta.page_image.twitter"       => "sometimes|nullable|image",
        ];
    }
}
