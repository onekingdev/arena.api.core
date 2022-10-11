<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Accounts\AccountNote;
use App\Models\Soundblock\Accounts\AccountNoteAttachment;

class SoundblockServiceNoteAttachSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $faker = Factory::create();

        foreach (AccountNote::all() as $objNote) {
            AccountNoteAttachment::create([
                "row_uuid"       => Util::uuid(),
                "note_id"        => $objNote->note_id,
                "note_uuid"      => Util::uuid(),
                "attachment_url" => $faker->url,
            ]);
        }

        Model::reguard();
    }
}
