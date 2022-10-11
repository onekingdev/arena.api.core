<?php

namespace App\Http\Controllers\Soundblock;

use App\Services\Common\Common;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\Soundblock\Project as ProjectService;
use App\Http\Requests\Soundblock\Reports\Report as ReportRequest;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Reports extends Controller {
    /** @var ProjectService */
    private ProjectService $objProjectService;
    /** @var Common */
    private Common $objPlanService;

    /**
     * Reports constructor.
     * @param ProjectService $objProjectService
     * @param Common $objPlanService
     */
    public function __construct(ProjectService $objProjectService, Common $objPlanService) {
        $this->objProjectService = $objProjectService;
        $this->objPlanService = $objPlanService;
    }

    public function getProjectReport(string $project, ReportRequest $objRequest) {
        if (!$this->objProjectService->checkUserInProject($project, Auth::user())) {
            return $this->apiReject(null, "Forbidden.", 403);
        }

        $arrResponse = [];

        $objProject = $this->objProjectService->find($project);
        $objAccount = $objProject->account;
        $objActivePlan = $objAccount->activePlan;

        if (is_null($objActivePlan)) {
            return $this->apiReject(null, "Invalid Account.", 400);
        }

        $objPlanType = $objActivePlan->planType;
        $arrResponse["limits"]["diskspace"] = $objPlanType->plan_diskspace * 1024;
        $arrResponse["limits"]["bandwidth"] = $objPlanType->plan_bandwidth * 1024;

        $arrResponse["report"] = $this->objProjectService->buildProjectReport($objProject, $objRequest->input("date_start"),
            $objRequest->input("date_end"));

        return $this->apiReply($arrResponse);
    }

    public function getAccountReport(string $account, ReportRequest $objRequest){
        $objAccount = $this->objPlanService->find($account);

        if (!$this->objPlanService->checkIsAccountMember($objAccount, Auth::user())) {
            return $this->apiReject(null, "Forbidden.", 403);
        }

        $arrResponse = [];
        $objActivePlan = $objAccount->activePlan;

        if (is_null($objActivePlan)) {
            return $this->apiReject(null, "Invalid Account.", 400);
        }

        $objPlanType = $objActivePlan->planType;

        $arrResponse["limits"]["diskspace"] = $objPlanType->plan_diskspace * 1024;
        $arrResponse["limits"]["bandwidth"] = $objPlanType->plan_bandwidth * 1024;

        $arrResponse["report"] = $this->objPlanService->buildAccountReport($objAccount, $objRequest->input("date_start"),
            $objRequest->input("date_end"));

        return $this->apiReply($arrResponse);
    }
}
