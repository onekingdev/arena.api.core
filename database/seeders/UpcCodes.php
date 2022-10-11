<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Data\UpcCode;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Database\Seeder;

class UpcCodes extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run() {
        $projectService = resolve(\App\Services\Soundblock\Project::class);

        while (($lastUpc = UpcCode::max(\DB::raw("SUBSTR(data_upc, 7, 5)")) ?? 19999) < 99999) {
            $upc = $projectService->generateUpc($lastUpc);

            UpcCode::create([
                "data_uuid"     => Util::uuid(),
                "data_upc"      => $upc,
                "flag_assigned" => Project::where("project_upc", $upc)->exists(),
            ]);
        }
    }
}
