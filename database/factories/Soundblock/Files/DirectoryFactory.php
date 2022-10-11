<?php

namespace Database\Factories\Soundblock\Files;

use App\Helpers\Util;
use App\Helpers\Constant;
use App\Models\Soundblock\Files\Directory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DirectoryFactory extends Factory {
    protected $model = Directory::class;

    public function definition() {
        $directoryName = $this->faker->word();
        $category = collect(config("constant.soundblock.file_category"))->random();

        return [
            "directory_uuid" => Util::uuid(),
            "directory_name" => $directoryName,
            "directory_path" => ucfirst($category),
            "directory_sortby" => ucfirst($category) . Constant::Separator . $directoryName
        ];
    }
}