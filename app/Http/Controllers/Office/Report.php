<?php

namespace App\Http\Controllers\Office;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Soundblock\Reports as ReportsService;

/**
 * @group Office Soundblock
 *
 */
class Report extends Controller{
    /** @var ReportsService */
    private ReportsService $reportService;

    /**
     * Report constructor.
     * @param ReportsService $reports
     */
    public function __construct(ReportsService $reports){
        $this->reportService = $reports;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function store(Request $request){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $boolResult = $this->reportService->store($request->file("file"));

        if ($boolResult) {
            return ($this->apiReply(null, "Data Updated Successfully.", 200));
        }

        return ($this->apiReject(null, "Something went wrong", 400));
    }
}
