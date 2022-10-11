<?php

namespace App\Services\Soundblock;

use App\Repositories\{
    Soundblock\Data\Languages,
    Soundblock\Data\Contributors,
    Soundblock\Data\Genres,
};

class Data {

    /** @var Languages */
    private Languages $languagesRepo;
    /** @var Contributors */
    private Contributors $contributorsRepo;
    /** @var Genres */
    private Genres $genresRepo;

    /**
     * @param Languages $languagesRepo
     * @param Contributors $contributorsRepo
     * @param Genres $genresRepo
     */
    public function __construct(Languages $languagesRepo, Contributors $contributorsRepo, Genres $genresRepo) {
        $this->languagesRepo = $languagesRepo;
        $this->contributorsRepo = $contributorsRepo;
        $this->genresRepo = $genresRepo;
    }

    public function getLanguages(array $arrParams, int $perPage) {
        [$objLanguages, $availableMeta] = $this->languagesRepo->findAll($arrParams, $perPage);

        return ([$objLanguages, $availableMeta]);
    }

    public function getAllLanguages(){
        return ($this->languagesRepo->allOrderByName());
    }

    public function getContributors(){
        return ($this->contributorsRepo->all());
    }

    public function getGenres(array $arrParams){
        return ($this->genresRepo->findAll($arrParams));
    }
}
