<?php

namespace App\Http\Resources\Soundblock;

use App\Http\Resources\Common\BaseResource;
use App\Models\Soundblock\Invites;

class InviteResource extends BaseResource {

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        $this->setStatusData();

        return ([
            "invite_uuid"          => $this->invite_uuid,
            "name"                 => $this->invite_name,
            "primary_email"        => [
                "user_auth_email" => $this->invite_email,
                "flag_primary"    => 1,
                "flag_verified"   => 0,
            ],
            "role"                 => $this->role,
            Invites::STAMP_CREATED => $this->{Invites::STAMP_CREATED},
            Invites::STAMP_UPDATED => $this->{Invites::STAMP_UPDATED},
        ]);
    }
}
