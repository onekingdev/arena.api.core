<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Projects\ProjectNote;

class SoundblockProjectNoteSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();
        $faker = Factory::create();

        foreach (Project::all() as $objProject) {
            ProjectNote::create([
                "note_uuid"     => Util::uuid(),
                "project_id"    => $objProject->project_id,
                "project_uuid"  => $objProject->project_uuid,
                "user_id"       => $objProject->account->user->user_id,
                "user_uuid"     => $objProject->account->user->user_uuid,
                "project_notes" => $faker->text,
            ]);
        }

        Model::reguard();
    }
}
