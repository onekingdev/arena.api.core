<?php


namespace App\Contracts\Music;


interface Genre {
    public function autocomplete(string $genre);
}