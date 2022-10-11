<?php

namespace Database\Factories\Core\Auth;

use App\Helpers\Util;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthGroupFactory extends Factory {

    protected $model = AuthGroup::class;

    public function definition() {
        return [
            "group_uuid" => Util::uuid(),
            "flag_critical" => 1
        ];
    }
}
