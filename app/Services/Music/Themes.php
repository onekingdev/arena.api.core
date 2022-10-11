<?php

namespace App\Services\Music;

use App\Repositories\Music\Theme;
use App\Contracts\Music\Themes as ThemesContract;

class Themes implements ThemesContract {
    /**
     * @var Theme
     */
    private Theme $objThemeRepository;

    /**
     * Genres constructor.
     * @param Theme $objThemeRepository
     */
    public function __construct(Theme $objThemeRepository) {
        $this->objThemeRepository = $objThemeRepository;
    }

    public function autocomplete(string $theme) {
        return $this->objThemeRepository->autocomplete($theme);
    }
}