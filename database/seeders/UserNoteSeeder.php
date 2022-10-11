<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Users\User;
use App\Models\Users\UserNote;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserNoteSeeder extends Seeder
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
        foreach(User::all() as $objUser)
        {
            UserNote::create([
                "note_uuid" => Util::uuid(),
                "user_id" => $objUser->user_id,
                "user_uuid" => $objUser->user_uuid,
                "user_notes" => $faker->text
            ]);
        }

        Model::reguard();
    }
}
