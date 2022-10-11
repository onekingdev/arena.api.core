<?php

namespace App\Contracts\Music\Artists;

use App\Models\Music\Artist\Artist;

interface Artists {
    public function index(?int $perPage = 10, array $filter = []);
    public function get(string $artist);
    public function create(array $artistData);
    public function update(string $artist, array $arrParams): Artist;

    public function autocomplete(string $name, int $perPage = 10);
    public function membersAutocomplete(string $artist, string $name, int $perPage = 10);
}
