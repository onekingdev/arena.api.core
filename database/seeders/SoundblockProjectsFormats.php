<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Data\ProjectsFormat;
use Illuminate\Database\Seeder;

class SoundblockProjectsFormats extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $arrProjectFormats = ["Album", "EP", "Single", "Ringtone"];

        foreach ($arrProjectFormats as $key => $projectFormat) {
            $iterator = ++$key;

            ProjectsFormat::create([
                "data_id"     => $iterator,
                "data_uuid"   => Util::uuid(),
                "data_format" => $projectFormat
            ]);
        }
    }
}
