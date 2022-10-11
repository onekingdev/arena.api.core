<?php

namespace Database\Factories\Soundblock;

use App\Helpers\Util;
use App\Models\Soundblock\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory {
    protected $model = Event::class;

    public function definition() {
        return [
            "event_uuid"     => Util::uuid(),
            "event_memo"     => $this->faker->word,
            "flag_processed" => false,
        ];
    }
}
