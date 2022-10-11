<?php

namespace App\Http\Requests\Soundblock\Project\Contract;

use App\Rules\Common\UniqueArray;
use App\Rules\Soundblock\Contract\AccountMember;
use App\Rules\Soundblock\Contract\Payout;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContract extends FormRequest {
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
            "members"          => ["required", "array", "min:1", new Payout($this->all())],
            "members.*.email"  => ["required_without:members.*.uuid", "email", new UniqueArray($this->input("members") ?? [], "email")],
            "members.*.name"   => ["required_without:members.*.uuid", "string"],
            "members.*.uuid"   => ["required_without_all:members.*.email,members.*.name", "string", "uuid",
                                    "exists:App\Models\Users\User,user_uuid", new AccountMember($this)],
            "members.*.payout" => ["required", "numeric", "max:100", "min:0", "not_in:0"],
            "members.*.role"   => "required|string",
        ];
    }
}
