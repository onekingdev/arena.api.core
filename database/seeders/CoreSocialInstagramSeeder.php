<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CoreSocialInstagramSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function run() {
        DB::unprepared(File::get(base_path() . '/database/sql/core//social/core_social_instagram.sql'));
    }
}
