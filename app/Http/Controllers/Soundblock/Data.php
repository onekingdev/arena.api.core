<?php

namespace App\Http\Controllers\Soundblock;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Soundblock\Data\GetGenres;
use App\Http\Requests\Soundblock\Data\GetLanguages;
use App\Services\Soundblock\Data as DataService;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Data extends Controller
{
    /** @var DataService */
    private DataService $dataService;

    /**
     * Data constructor.
     * @param DataService $dataService
     */
    public function __construct(DataService $dataService){
        $this->dataService = $dataService;
    }

    public function getLanguages(GetLanguages $objRequest){
        [$objLanguages, $availableMeta] = $this->dataService->getLanguages($objRequest->all(), $objRequest->input("per_page", 10));

        return ($this->apiReply($objLanguages, "", Response::HTTP_OK, $availableMeta));
    }

    public function getContributors(){
        $objContributors = $this->dataService->getContributors();

        return ($this->apiReply($objContributors, "", Response::HTTP_OK));
    }

    public function getGenres(GetGenres $objRequest){
        $objGenres = $this->dataService->getGenres($objRequest->only("flag_primary", "flag_secondary"));

        return ($this->apiReply($objGenres, "", Response::HTTP_OK));
    }
}
