<?php

namespace App\Http\Requests\Common\Notification;

use App\Rules\Common\Notification\SettingPosition;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSetting extends FormRequest {
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
            "flag_apparel"       => "boolean",
            "flag_arena"         => "boolean",
            "flag_catalog"       => "boolean",
            "flag_ux"            => "boolean",
            "flag_merchandising" => "boolean",
            "flag_music"         => "boolean",
            "flag_office"        => "boolean",
            "flag_soundblock"    => "boolean",
            "setting.play_sound" => "required|boolean",
            "setting.position"   => ["required", "string", new SettingPosition],
            "setting.show_time"  => "required|integer",
            "setting.per_page"   => "required|integer",
        ]);
    }
}
