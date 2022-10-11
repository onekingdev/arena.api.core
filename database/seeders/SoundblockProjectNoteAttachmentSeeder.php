<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Projects\ProjectNote;
use App\Models\Soundblock\Projects\ProjectNoteAttachment;

class SoundblockProjectNoteAttachmentSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();
        $faker = Factory::create();

        foreach (ProjectNote::all() as $objNote) {
            ProjectNoteAttachment::create([
                "row_uuid"       => Util::uuid(),
                "note_id"        => $objNote->note_id,
                "note_uuid"      => $objNote->note_uuid,
                "attachment_url" => $faker->imageUrl(),
            ]);
        }

        Model::reguard();
    }
}
