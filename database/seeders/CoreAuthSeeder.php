<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\Auth\AuthModel;
use App\Models\Core\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class CoreAuthSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $auths = [
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Apparel",
                "app_id"    => App::where("app_name", "apparel")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "apparel")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Arena",
                "app_id"    => App::where("app_name", "arena")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "arena")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Catalog",
                "app_id"    => App::where("app_name", "catalog")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "catalog")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.IO",
                "app_id"    => App::where("app_name", "io")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "io")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Merchandising",
                "app_id"    => App::where("app_name", "merchandising")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "merchandising")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Music",
                "app_id"    => App::where("app_name", "music")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "music")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Office",
                "app_id"    => App::where("app_name", "office")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "office")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Soundblock",
                "app_id"    => App::where("app_name", "soundblock")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "soundblock")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Account",
                "app_id"    => App::where("app_name", "account")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "account")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Embroidery",
                "app_id"    => App::where("app_name", "embroidery")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "embroidery")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Facecoverings",
                "app_id"    => App::where("app_name", "facecoverings")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "facecoverings")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Prints",
                "app_id"    => App::where("app_name", "prints")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "prints")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Screenburning",
                "app_id"    => App::where("app_name", "screenburning")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "screenburning")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Sewing",
                "app_id"    => App::where("app_name", "sewing")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "sewing")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Tourmask",
                "app_id"    => App::where("app_name", "tourmask")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "tourmask")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Soundblock.Web",
                "app_id"    => App::where("app_name", "soundblock.web")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "soundblock.web")->firstOrFail()->app_uuid,
            ],
            [
                "auth_uuid" => Util::uuid(),
                "auth_name" => "App.Ux",
                "app_id"    => App::where("app_name", "ux")->firstOrFail()->app_id,
                "app_uuid"  => App::where("app_name", "ux")->firstOrFail()->app_uuid,
            ],
        ];

        foreach ($auths as $auth) {
            AuthModel::create($auth);
        }

        Model::reguard();
    }
}
