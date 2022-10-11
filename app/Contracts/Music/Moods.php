<?php

namespace App\Contracts\Music;

interface Moods {
    public function autocomplete(string $mood);
}