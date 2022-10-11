<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Music\Themes\Autocomplete;
use App\Contracts\Music\Themes as ThemesContract;

/**
 * @group Office Music
 *
 */
class Themes extends Controller
{
    /** @var ThemesContract */
    private ThemesContract $themeContract;

    /**
     * Genres constructor.
     * @param ThemesContract $themeContract
     */
    public function __construct(ThemesContract $themeContract) {
        $this->themeContract = $themeContract;
    }

    public function autocomplete(Autocomplete $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrThemes = $this->themeContract->autocomplete($objRequest->input("theme"));

        return $this->apiReply($arrThemes);
    }
}
