<?php

namespace Database\Factories\Soundblock;

use App\Helpers\Util;
use Illuminate\Support\Str;
use App\Models\Soundblock\Invites;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvitesFactory extends Factory {
    protected $model = Invites::class;

    public function definition() {
        return [
            "invite_uuid"  => Util::uuid(),
            "invite_hash"  => Str::random(32),
            "invite_email" => $this->faker->email,
            "invite_name"  => $this->faker->firstName,
        ];
    }
}