<?php

namespace Database\Factories\Soundblock\Projects;

use App\Models\Soundblock\Projects\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory {
    protected $model = Project::class;

    public function definition() {
        return [
            "project_uuid" => \App\Helpers\Util::uuid(),
            "project_title" => $this->faker->word,
            "project_type" => "Album",
            "project_date" => $this->faker->date(),
            "project_upc" => $this->faker->randomDigit
        ];
    }
}