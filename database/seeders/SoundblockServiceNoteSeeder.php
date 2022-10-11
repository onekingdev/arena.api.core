<?php

namespace Database\Seeders;

use App\Helpers\Util;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Soundblock\Accounts\AccountNote;

class SoundblockServiceNoteSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $faker = Factory::create();

        foreach (Account::all() as $objAccount) {
            AccountNote::create([
                "note_uuid"     => Util::uuid(),
                "account_id"    => $objAccount->account_id,
                "account_uuid"  => $objAccount->account_uuid,
                "user_id"       => $objAccount->user->user_id,
                "user_uuid"     => $objAccount->user->user_uuid,
                "account_notes" => $faker->text,
            ]);
        }

        Model::reguard();
    }
}
