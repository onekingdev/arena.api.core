<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApparelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_categories.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_attributes.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_files.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products_attributes.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products_files.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products_prices.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products_sizes.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products_colors.sql'));
        DB::unprepared(File::get(base_path() . '/database/sql/apparel/apparel_products_related.sql'));
    }
}
