<?php

namespace App\Services\Music;

use App\Contracts\Music\Genre as GenreContract;
use App\Repositories\Music\Genre;

class Genres implements GenreContract {
    /**
     * @var Genre
     */
    private Genre $objGenreRepository;

    /**
     * Genres constructor.
     * @param Genre $objGenreRepository
     */
    public function __construct(Genre $objGenreRepository) {
        $this->objGenreRepository = $objGenreRepository;
    }

    public function autocomplete(string $genre) {
        return $this->objGenreRepository->autocomplete($genre);
    }
}