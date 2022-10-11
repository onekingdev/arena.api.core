<?php

namespace Database\Factories\Soundblock\Files;

use App\Helpers\Util;
use App\Models\Soundblock\Files\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory {
    protected $model = File::class;

    public function definition() {
        $name = rand(1, 1000);
        return [
            "file_uuid" => Util::uuid(),
            "file_name" => $name,
            "file_sortby" => "test",
            "file_md5" =>  md5($name)
        ];
    }
}