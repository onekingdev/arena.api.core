<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Data\IsrcCode;
use App\Models\Soundblock\Track;
use Illuminate\Database\Seeder;

class IsrcCodes extends Seeder
{
    const ISRC_PREFIX = "US-AEA-81-";
    const USED_ISRC_INCREMENTS = [10000, 10001, 10002, 10003, 10004, 10005];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        while (($intCode = IsrcCode::max(\DB::raw("SUBSTR(data_isrc, 11, 5)"))) < 99999) {
            $isrc = self::ISRC_PREFIX . str_pad(++$intCode, 5, 0, STR_PAD_LEFT);

            IsrcCode::create([
                "data_uuid" => Util::uuid(),
                "data_isrc" => $isrc,
                "flag_assigned" => Track::where("track_isrc", $isrc)->exists() || array_search($intCode, self::USED_ISRC_INCREMENTS) !== false
            ]);
        }
    }
}
