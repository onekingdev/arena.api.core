<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;
use App\Contracts\Music\Artists\Artists as ArtistsContract;
use App\Http\Requests\Music\Artist\Index;

/**
 * @group Music
 *
 * Music routes
 */
class Artists extends Controller {
    /**
     * @var ArtistsContract
     */
    private ArtistsContract $artistsService;

    /**
     * Artists constructor.
     * @param ArtistsContract $artistsService
     */
    public function __construct(ArtistsContract $artistsService) {
        $this->artistsService = $artistsService;
    }

    public function index(Index $indexRequest) {
        [$objArtists, $availableMetaData] = $this->artistsService->index($indexRequest->input("per_page", 10));

        return $this->apiReply($objArtists);
    }
}
