<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApparelProducts extends Seeder
{
    const PRODUCTS_SQL= [
        "apparel_products.sql"
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() {
//        ini_set('memory_limit', -1);
//        foreach(self::PRODUCTS_SQL as $productFile) {
//            $fileContent = File::get(base_path() . "/database/sql/{$productFile}");
//            $parsedSql = explode(");", $fileContent);
//            foreach($parsedSql as $query) {
//                if (!empty(trim($query))) {
//                    DB::unprepared(trim($query) . ");");
//                }
//            }
//        }

        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products.sql'));
    }
}
