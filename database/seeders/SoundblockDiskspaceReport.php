<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Projects\Project;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SoundblockDiskspaceReport extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $arrProjects = Project::all();
        $objDateEnd = now();
        $objDateStart = now()->subMonth();

        foreach ($arrProjects as $objProject) {
            foreach ($objDateStart->range($objDateEnd, 1, "day") as $objDay) {
                $strDay = $objDay->format("Y-m-d");

                $objProject->diskSpaceReport()->create([
                    "row_uuid"     => Util::uuid(),
                    "project_uuid" => $objProject->project_uuid,
                    "report_value" => rand(10000, 1073741824),
                    "report_date"  => $strDay,
                ]);
            }

        }
    }
}
