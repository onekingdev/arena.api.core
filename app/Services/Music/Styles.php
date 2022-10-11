<?php


namespace App\Services\Music;

use App\Repositories\Music\Style;
use App\Contracts\Music\Styles as StylesContract;

class Styles implements StylesContract {
    /**
     * @var Style
     */
    private Style $objStyleRepository;

    /**
     * Styles constructor.
     * @param Style $objStyleRepository
     */
    public function __construct(Style $objStyleRepository) {
        $this->objStyleRepository = $objStyleRepository;
    }

    public function autocomplete(string $mood) {
        return $this->objStyleRepository->autocomplete($mood);
    }
}