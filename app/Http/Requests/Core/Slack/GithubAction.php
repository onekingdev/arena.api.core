<?php

namespace App\Http\Requests\Core\Slack;

use Illuminate\Foundation\Http\FormRequest;

class GithubAction extends FormRequest {
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
            "repo_owner" => "required|string",
            "repo"       => "required|string",
            "repo_url"   => "required|string",
            "commit"     => "required|string",
            "actor"      => "required|string",
            "status"     => "required|string|in:success,failure,cancelled",
        ];
    }
}
