<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Data\ProjectsRole;
use Illuminate\Database\Seeder;

class SoundblockProjectsRoles extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $arrProjectRoles = [
            "Administrator", "Band Member", "Booking Agent", "Composer", "Designer", "Investor", "Label", "Lawyer", "Manager",
            "Owner", "Publisher", "Writer", "(Other)",
        ];

        foreach ($arrProjectRoles as $key => $projectRole) {
            $iterator = ++$key;

            ProjectsRole::create([
                "data_id"   => $iterator,
                "data_uuid" => Util::uuid(),
                "data_role" => $projectRole
            ]);
        }
    }
}
