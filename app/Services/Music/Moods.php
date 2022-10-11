<?php


namespace App\Services\Music;


use App\Contracts\Music\Moods as MoodsContract;
use App\Repositories\Music\Mood;

class Moods implements MoodsContract {
    /**
     * @var Mood
     */
    private Mood $objMoodRepository;

    public function __construct(Mood $objMoodRepository) {
        $this->objMoodRepository = $objMoodRepository;
    }

    public function autocomplete(string $mood) {
        return $this->objMoodRepository->autocomplete($mood);
    }
}