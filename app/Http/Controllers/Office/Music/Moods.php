<?php

namespace App\Http\Controllers\Office\Music;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Music\Moods\Autocomplete;
use App\Contracts\Music\Moods as MoodsContract;

/**
 * @group Office Music
 *
 */
class Moods extends Controller
{
    /** @var MoodsContract */
    private MoodsContract $moodsService;

    /**
     * Moods constructor.
     * @param MoodsContract $moodsService
     */
    public function __construct(MoodsContract $moodsService) {
        $this->moodsService = $moodsService;
    }

    public function autocomplete(Autocomplete $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrMoods = $this->moodsService->autocomplete($objRequest->input("mood"));

        return $this->apiReply($arrMoods);
    }
}
