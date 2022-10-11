<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Soundblock\Projects\Metadata\Theme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
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

        $themes = [
            [
                "row_uuid" => Util::uuid(),
                "theme_id" => 1,
                "theme_uuid" => Util::uuid(),
                "name" => "Tafelmusik"
            ],
            [
                "row_uuid" => Util::uuid(),
                "theme_id" => 2,
                "theme_uuid" => Util::uuid(),
                "name" => "Tails out"
            ],
            [
                "row_uuid" => Util::uuid(),
                "theme_id" => 3,
                "theme_uuid" => Util::uuid(),
                "name" => "Take"
            ]
        ];

        foreach($themes as $theme)
        {
            $objTheme = new Theme();
            $objTheme->create($theme);
        }

        Model::reguard();
    }
}
