<?php

namespace Database\Factories\Apparel;

use App\Helpers\Util;
use App\Models\Apparel\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory {

    protected $model = Attribute::class;

    public function definition() {
        return [
            "attribute_uuid" => Util::uuid()
        ];
    }

    public function color() {
        return $this->state(function (array $attributes) {
            return [
                "attribute_type" => "color",
                "attribute_name" => ucfirst($this->faker->colorName)
            ];
        });
    }

    public function size() {
        return $this->state(function (array $attributes) {
            $sizes = ["SML", "MED", "LRG", "XLG"];

            return [
                "attribute_type" => "size",
                "attribute_name" => $this->faker->randomElement($sizes)
            ];
        });
    }

    public function style() {
        return $this->state(function (array $attributes) {
            $styles = ["Crew Neck T-Shirts", "Singlets", "Long Sleeve T-Shirts", "Tank Tops", "Shirts"];

            return [
                "attribute_type" => "style",
                "attribute_name" => $this->faker->randomElement($styles)
            ];
        });
    }

    public function weight() {
        return $this->state(function (array $attributes) {
            $weight = ["Heavy", "Light", "Mid"];

            return [
                "attribute_type" => "weight",
                "attribute_name" => $this->faker->randomElement($weight)
            ];
        });
    }
}