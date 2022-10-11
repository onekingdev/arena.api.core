<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Territories;
use Illuminate\Database\Seeder;

class TerritoriesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $handle = fopen(database_path("csv/territories.csv"),'r');

        $arrCountries = [];
        $arrTerritories = [];
        $i = 0;

        while ( ($data = fgetcsv($handle, 0, ";") ) !== false ) {
            if ($i === 0) {
                $arrCountries = $data;
            } else {
                foreach ($data as $key => $country) {
                    if (strlen($country) > 0) {
                        $arrTerritories[$arrCountries[$key]][] = $country;
                    }
                }
            }

            $i++;
        }

        foreach ($arrTerritories as $strRegion => $arrCountries) {
            foreach ($arrCountries as $strCountry) {
                Territories::create([
                    "territory_uuid" => Util::uuid(),
                    "territory_region" => $strRegion,
                    "territory_country" => $strCountry,
                ]);
            }
        }
    }
}
