<?php

namespace App\Http\Requests\Common\Notification;

use Illuminate\Foundation\Http\FormRequest;

class NotificationState extends FormRequest {
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
            "notification"       => "required|uuid|exists:notifications,notification_uuid",
            "notification_state" => "required|notification_state",
        ];
    }
}
