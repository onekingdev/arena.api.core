<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\App;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CoreAppSeeder extends Seeder
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

        $commonApps = [
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "apparel"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "arena"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "catalog"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "io"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "merchandising"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "music"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "office"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "soundblock"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "account"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "embroidery"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "facecoverings"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "prints"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "screenburning"
            ],
            [
                "app_uuid" => Util::uuid(),
                "app_name" => "sewing"
            ],[
                "app_uuid" => Util::uuid(),
                "app_name" => "tourmask"
            ],[
                "app_uuid" => Util::uuid(),
                "app_name" => "soundblock.web"
            ],[
                "app_uuid" => Util::uuid(),
                "app_name" => "ux"
            ],
        ];

        foreach($commonApps as $commonApp)
        {
            App::create($commonApp);
        }

        Model::reguard();
    }
}
