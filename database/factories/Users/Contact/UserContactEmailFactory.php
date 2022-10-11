<?php

namespace Database\Factories\Users\Contact;

use App\Helpers\Util;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserContactEmailFactory extends Factory {

    protected $model = UserContactEmail::class;

    public function definition() {
        return [
            "row_uuid"          => Util::uuid(),
            "user_auth_email"   => $this->faker->email,
            "flag_primary"      => false,
            "flag_verified"     => false,
            "verification_hash" => $this->faker->sha256,
        ];
    }

    public function primary() {
        return $this->state(function (array $attributes) {
            return [
                "flag_primary" => true,
            ];
        });
    }

    public function verified() {
        return $this->state(function (array $attributes) {
            return [
                "flag_verified" => true,
            ];
        });
    }
}


