<?php

namespace Database\Factories\Users;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
    protected $model = User::class;

    public function definition() {
        return [
            "user_uuid" => \App\Helpers\Util::uuid(),
            "name_first" => $this->faker->firstName,
            "name_middle" => $this->faker->userName,
            "name_last" => $this->faker->lastName,
            "user_password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi", // password
            "remember_token" => Str::random(10),
        ];
    }
}
