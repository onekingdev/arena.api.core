<?php

namespace App\Http\Controllers\Office;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Platform\Autocomplete;
use App\Services\Soundblock\Platform as PlatformService;

/**
 * @group Office Soundblock
 *
 */
class Platform extends Controller
{
    /** @var PlatformService */
    private PlatformService $platformService;

    /**
     * Platform constructor.
     * @param PlatformService $platformService
     */
    public function __construct(PlatformService $platformService){
        $this->platformService = $platformService;
    }

    public function autocomplete(Autocomplete $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $result = $this->platformService->autocomplete($objRequest->input("name"));

        if ($result) {
            return ($this->apiReply($result, "", 200));
        }

        return ($this->apiReject(null, "Users not found.", 400));
    }
}
