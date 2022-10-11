<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\UserNote;
use App\Models\Users\UserNoteAttachment;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserNoteAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Model::unguard();
        $faker = Factory::create();

        foreach(UserNote::all() as $objNote)
        {
            UserNoteAttachment::create([
                "row_uuid" => Util::uuid(),
                "note_id" => $objNote->note_id,
                "note_uuid" => $objNote->note_uuid,
                "attachment_url" => $faker->url
            ]);
        }

        Model::reguard();
    }
}
