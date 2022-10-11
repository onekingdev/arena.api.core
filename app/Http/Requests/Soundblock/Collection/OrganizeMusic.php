<?php

namespace App\Http\Requests\Soundblock\Collection;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Soundblock\Collection\TrackVolumeNumber;

class OrganizeMusic extends FormRequest {
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
            "project"              => "required|uuid|exists:soundblock_projects,project_uuid",
            "file_category"        => "required|file_category",
            "collection"           => "required|uuid|exists:soundblock_collections,collection_uuid",
            "volume_number"        => ["required", "integer", new TrackVolumeNumber($this->all())],
            "files"                => "required|array|min:1",
            "files.*.track_number" => "required|integer|min:1",
            "files.*.file_uuid"    => "required|uuid|exists:soundblock_files,file_uuid",
        ]);
    }
}
