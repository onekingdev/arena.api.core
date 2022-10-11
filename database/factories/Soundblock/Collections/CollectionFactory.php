<?php

namespace Database\Factories\Soundblock\Collections;

use App\Helpers\Util;
use App\Models\Soundblock\Collections\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory {
    protected $model = Collection::class;

    public function definition() {
        return [
            "collection_uuid" => Util::uuid(),
            "collection_comment" => $this->faker->word
        ];
    }
}

