<?php

namespace Database\Factories\Soundblock\Projects;

use App\Models\Soundblock\Projects\ProjectDraft;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectDraftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectDraft::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "account_uuid" => \App\Helpers\Util::uuid(),
            "draft_uuid" => \App\Helpers\Util::uuid(),
            "draft_json" => [
                "project_title" => "Test",
                "project_type" => "Album",
                "project_label" => "Label",
                "project_date" => "2020-12-30",
                "artwork" => "https://example.com",
                "step" => 1,
            ]
        ];
    }
}
