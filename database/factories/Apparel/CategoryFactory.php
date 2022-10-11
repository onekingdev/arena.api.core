<?php

namespace Database\Factories\Apparel;

use App\Helpers\Util;
use App\Models\Apparel\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory {

    protected $model = Category::class;

    public function definition() {
        return [
            "category_uuid" => Util::uuid(),
            "category_name" => strtolower($this->faker->word) . microtime()
        ];
    }
}
