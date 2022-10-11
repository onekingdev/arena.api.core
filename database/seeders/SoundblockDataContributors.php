<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soundblock\Data\Contributor;
use Util;

class SoundblockDataContributors extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrContributors = [
            "Actor",
            "Arranger",
            "Choir",
            "Composer",
            "Conductor",
            "Contributing Artist",
            "Engineer",
            "Ensemble",
            "Featuring",
            "Lyricist",
            "Mixer",
            "Orchestra",
            "Performer",
            "Producer",
            "Remixer",
            "Soloist",
            "Translator",
            "Video Director",
            "Video Producer",
            "Writer"
        ];

        foreach ($arrContributors as $contributor) {
            Contributor::create([
                "data_uuid" => Util::uuid(),
                "data_contributor" => $contributor,
            ]);
        }
    }
}
