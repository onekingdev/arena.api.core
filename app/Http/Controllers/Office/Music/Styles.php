<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Music\Styles\Autocomplete;

/**
 * @group Office Music
 *
 */
class Styles extends Controller
{
    private \App\Contracts\Music\Styles $stylesService;

    /**
     * Genres constructor.
     * @param \App\Contracts\Music\Styles $stylesService
     */
    public function __construct(\App\Contracts\Music\Styles $stylesService) {
        $this->stylesService = $stylesService;
    }

    public function autocomplete(Autocomplete $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrStyles = $this->stylesService->autocomplete($objRequest->input("style"));

        return $this->apiReply($arrStyles);
    }
}
