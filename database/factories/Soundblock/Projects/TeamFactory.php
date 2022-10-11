<?php

namespace Database\Factories\Soundblock\Projects;

use App\Helpers\Util;
use App\Models\Soundblock\Projects\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory {
    protected $model = Team::class;

    public function definition() {
        return [
            "team_uuid" => Util::uuid()
        ];
    }
}