<?php

namespace App\Http\Controllers\Soundblock;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Jobs\Soundblock\Ledger\ServiceLedger;
use App\Http\Transformers\Account as AccountTransformer;
use App\Models\{
    Users\User,
    Soundblock\Projects\Project
};
use App\Http\Requests\Soundblock\Account\{
    ReportDates,
    GetAccountByProject,
    UpdateAccount,
    UpdateAccountInfo
};
use App\Services\{
    Common\Common,
    Soundblock\Payment as PaymentService,
    Soundblock\Project as ProjectService,
    Soundblock\Ledger\ServiceLedger as ServiceLedgerService
};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Account extends Controller {
    /** @var Common */
    private Common $commonService;
    /** @var ProjectService */
    private ProjectService $projectService;

    /**
     * @param Common $commonService
     * @param ProjectService $projectService
     */
    public function __construct(Common $commonService, ProjectService $projectService) {
        $this->commonService = $commonService;
        $this->projectService = $projectService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function index() {
        $arrAccounts = $this->commonService->findByUser(Auth::user());

        return ($this->collection($arrAccounts, new AccountTransformer(["user"])));
    }

    /**
     * @param string $account
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function show(string $account) {
        $objAccount = $this->commonService->find($account);

        return ($objAccount->load("activePlan"));
    }

    /**
     * @param GetAccountByProject $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function getByProject(GetAccountByProject $objRequest) {
        /** @var Project */
        $objProject = $this->projectService->find($objRequest->project, true);
        /** @var Account */
        $objAccount = $objProject->account;

        return ($this->apiReply($objAccount->load(["plans"])));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function userAccount() {
        /** @var User $objUser*/
        $objUser = Auth::user();

        if ($objUser->account) {
            return ($this->item($objUser->account, new AccountTransformer(["plans", "transactions"], true, true)));
        }

        return ($this->apiReject(null, "The user has not his own account.", Response::HTTP_BAD_REQUEST));
    }

    public function getUserAccounts(){
        /** @var User $objUser */
        $objUser = Auth::user();

        return ($this->apiReply($objUser->userAccounts->load("activePlan.planType")));
    }

    /**
     * @param string $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function getAccountTransactions(string $account) {
        $objAccount = $this->commonService->find($account);

        if ($objAccount) {
            $objTransactions = $objAccount->transactions()->with("accountingType")->get();

            return $this->apiReply($objTransactions);
        }

        return ($this->apiReject(null, "Account not found.", Response::HTTP_BAD_REQUEST));
    }

    /**
     * @param string $account
     * @param PaymentService $paymentService
     * @param ReportDates $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function getAccountDiscReports(string $account, PaymentService $paymentService, ReportDates $objRequest){
        $objAccount = $this->commonService->find($account);

        if (Auth::id() !== $objAccount->user_id) {
            return $this->apiReject(null, "Only account owner has access to the reports.", Response::HTTP_FORBIDDEN);
        }

        $arrReports = $paymentService->discReports(
            $objAccount,
            $objRequest->input("start_date", null),
            $objRequest->input("end_date", null)
        );

        return ($this->apiReply($arrReports, "Success.", Response::HTTP_OK));
    }

    /**
     * @param string $account
     * @param PaymentService $paymentService
     * @param ReportDates $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function getAccountBillingsReports(string $account, PaymentService $paymentService, ReportDates $objRequest){
        $objAccount = $this->commonService->find($account);

        if (Auth::id() !== $objAccount->user_id) {
            return $this->apiReject(null, "Only account owner has access to the reports.", Response::HTTP_FORBIDDEN);
        }

        $arrReports = $paymentService->billingReport(
            $objAccount,
            $objRequest->input("start_date", null),
            $objRequest->input("end_date", null)
        );

        return ($this->apiReply($arrReports, "Success.", Response::HTTP_OK));
    }

    /**
     * @param string|null $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function report(?string $account = null) {
        /** @var User $objUser*/
        $objUser = Auth::user();

        if (is_null($account)) {
            $objAccount = $this->commonService->getActiveUserAccount($objUser);
        } else {
            $objAccount = $this->commonService->findUsersAccount($objUser, $account);

            if (!$objAccount) {
                return $this->apiReject(null, "Account Not Found.", Response::HTTP_NOT_FOUND);
            }
        }

        $strGroup = "App.Soundblock.Account." . $objAccount->account_uuid;

        if ($objAccount->user_id !== $objUser->user_id && !is_authorized($objUser, $strGroup,
                "App.Soundblock.Account.Report.Payments", "soundblock", true, true)) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $report = $this->commonService->getMonthlyUserReport($objAccount);

        return $this->apiReply($report);
    }

    /**
     * @param UpdateAccount $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateAccount $objRequest) {
        $objAccount = $this->commonService->find($objRequest->account);
        $objAccount = $this->commonService->update($objAccount, $objRequest->all());

        return ($this->item($objAccount, new AccountTransformer));
    }

    /**
     * @param string $service
     * @param UpdateAccountInfo $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     */
    public function updateAccount(string $service, UpdateAccountInfo $objRequest) {
        $objAccount = $this->commonService->find($service);

        if (Auth::id() !== $objAccount->user_id) {
            return $this->apiReject(null, "Only Account Owner Can Modify Contract Info", Response::HTTP_FORBIDDEN);
        }

        $objAccount = $this->commonService->updateName($objAccount, $objRequest->input("name"));

        dispatch(new ServiceLedger($objAccount, ServiceLedgerService::UPDATE_EVENT))->onQueue("ledger");

        return ($this->item($objAccount, new AccountTransformer));
    }

    /**
     * @param string $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function detachUser(string $account){
        $objUser = Auth::user();
        $boolResult = $this->commonService->detachUser($objUser, $account);

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", 400));
        }

        return ($this->apiReply(null, "User detached successfully.", 200));
    }

    /**
     * @param string $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function deleteAccount(string $account){
        $objAccount = $this->commonService->find($account);

        if (Auth::id() !== $objAccount->user_id) {
            return $this->apiReject(null, "Only Account Owner Can Modify Contract Info", Response::HTTP_FORBIDDEN);
        }

        $boolResult = $this->commonService->deleteAccount($objAccount);

        if ($boolResult) {
            return ($this->apiReply(null, "Account deleted successfully.", Response::HTTP_OK));
        }

        return ($this->apiReply(null, "Account not deleted.", Response::HTTP_BAD_REQUEST));
    }
}
