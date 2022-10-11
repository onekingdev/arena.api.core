<?php

namespace App\Http\Controllers\Office;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Contracts\Soundblock\Artist\Artist as ArtistService;
use App\Http\Requests\Office\TypeAheads\Artist as TypeAhead;

/**
 * @group Office Soundblock
 *
 */
class Artist extends Controller {
    private ArtistService $artistService;

    /**
     * Artist constructor.
     * @param ArtistService $artistService
     */
    public function __construct(ArtistService $artistService) {
        $this->artistService = $artistService;
    }

    public function typeahead(TypeAhead $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtists = $this->artistService->typeahead($objRequest->only(["project", "artist", "account"]));

        return ($this->apiReply($objArtists, "", Response::HTTP_OK));
    }
}
