<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Music\Artist\Index;
use App\Http\Requests\Music\Artist\Create;
use App\Http\Requests\Music\Artist\Update;
use App\Http\Requests\Music\Artist\Autocomplete;
use App\Contracts\Music\Artists\Artists as ArtistsContract;

/**
 * @group Office Music
 *
 */
class Artists extends Controller {
    /** @var ArtistsContract */
    private ArtistsContract $artistsService;

    /**
     * Artists constructor.
     * @param ArtistsContract $artistsService
     */
    public function __construct(ArtistsContract $artistsService) {
        $this->artistsService = $artistsService;
    }

    public function index(Index $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$objArtists, $availableMetaData] = $this->artistsService->index($objRequest->input("per_page", 10), $objRequest->except("per_page"));

        return ($this->apiReply($objArtists, "", Response::HTTP_OK, $availableMetaData));
    }

    public function get(string $artist) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtist = $this->artistsService->get($artist);

        return $this->apiReply($objArtist);
    }

    public function autocomplete(Autocomplete $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtists = $this->artistsService->autocomplete($objRequest->input("name"), $objRequest->input("per_page", 10));

        return ($this->apiReply($objArtists, "", Response::HTTP_OK));
    }

    public function membersAutocomplete(string $artist, Autocomplete $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtistMembers = $this->artistsService->membersAutocomplete($artist, $objRequest->input("name"), $objRequest->input("per_page", 10));

        return ($this->apiReply($objArtistMembers, "", Response::HTTP_OK));
    }

    public function create(Create $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtist = $this->artistsService->create($objRequest->only([
            "name", "active_date", "born", "allmusic_url", "amazon_url", "itunes_url", "lastfm_url", "spotify_url",
            "wikipedia_url", "genres", "styles", "themes", "moods", "members",
        ]));

        return $this->apiReply($objArtist);
    }

    /**
     * @param Update $objRequest
     * @param string $artist
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function update(Update $objRequest, string $artist){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtist = $this->artistsService->update($artist, $objRequest->all());

        return ($this->apiReply($objArtist, "", 200));
    }
}
