<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Collections\Collection;

class SoundblockCollectionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $faker = Factory::create();

        foreach (Project::find([1, 2]) as $objProject) {
            Collection::create([
                "collection_uuid"            => Util::uuid(),
                "project_id"                 => $objProject->project_id,
                "project_uuid"               => $objProject->project_uuid,
                "collection_comment"         => $faker->name,
                "flag_changed_music"         => true,
                "flag_changed_video"         => true,
                "flag_changed_merchandising" => true,
                "flag_changed_other"         => true,
            ]);
        }

        // For testing the history
        $jinProject = Project::find(3);
        for ($i = 0; $i < 4; $i++) {
            Collection::create([
                "collection_uuid"            => Util::uuid(),
                "project_id"                 => $jinProject->project_id,
                "project_uuid"               => $jinProject->project_uuid,
                "collection_comment"         => "**jin",
                "flag_changed_music"         => true,
                "flag_changed_video"         => true,
                "flag_changed_merchandising" => true,
                "flag_changed_other"         => true,
            ]);
        }

        foreach (Project::find([4, 5, 6]) as $objProject) {
            Collection::create([
                "collection_uuid"            => Util::uuid(),
                "project_id"                 => $objProject->project_id,
                "project_uuid"               => $objProject->project_uuid,
                "collection_comment"         => $faker->name,
                "flag_changed_music"         => true,
                "flag_changed_video"         => true,
                "flag_changed_merchandising" => true,
                "flag_changed_other"         => true,
            ]);
        }

        Model::reguard();
    }
}
