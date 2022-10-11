<?php

namespace Database\Seeders;

use App\Helpers\Util;
use App\Models\Core\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\Support\Support;

class SupportSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        Model::unguard();

        $supportCategories = config("constant.support.category");

        foreach (App::all() as $objApp) {
            foreach ($supportCategories as $category) {
                Support::create([
                    "support_uuid"     => Util::uuid(),
                    "app_id"           => $objApp->app_id,
                    "app_uuid"         => $objApp->app_uuid,
                    "support_category" => $category,
                ]);
            }
        }
        Model::reguard();
    }
}
