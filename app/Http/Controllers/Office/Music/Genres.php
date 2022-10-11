<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use App\Contracts\Music\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Music\Genres\Autocomplete;

/**
 * @group Office Music
 *
 */
class Genres extends Controller
{
    /** @var Genre */
    private Genre $genreService;

    /**
     * Genres constructor.
     * @param Genre $genreService
     */
    public function __construct(Genre $genreService) {
        $this->genreService = $genreService;
    }

    public function autocomplete(Autocomplete $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrGenres = $this->genreService->autocomplete($objRequest->input("genre"));

        return $this->apiReply($arrGenres);
    }
}
