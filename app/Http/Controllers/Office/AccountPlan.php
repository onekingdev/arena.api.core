<?php

namespace App\Http\Controllers\Office;

use Auth;
use Mail;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Mail\Office\ServicePlan as ServicePlanMail;
use App\Services\{
    Common\Common,
    Common\AccountPlan as AccountPlanService,
};
use App\Http\Requests\Office\{
    AccountPlan\ChangeAccountPlan,
    AccountPlan\GetPlans,
    TypeAheads\AccountPlan as TypeAheadRequest,
    AccountPlan\UpdateRenewalDay,
    AccountPlan\CreateAccountPlan
};
use App\Http\Transformers\{
    Account as AccountTransformer,
    Soundblock\AccountPlan as AccountPlanTransformer
};
use App\Repositories\{
    Common\App as AppRepository,
    User\User as UserRepository,
    Accounting\AccountingType as AccountingTypeRepository,
    Soundblock\Data\PlansTypes as PlansTypesRepository
};

/**
 * @group Office Soundblock
 *
 */
class AccountPlan extends Controller
{
    /** @var AccountPlanService */
    private AccountPlanService $accountPlan;
    /** @var Common */
    private Common $commonService;
    /** @var AccountingTypeRepository */
    private AccountingTypeRepository $accountingTypeRepo;
    /** @var UserRepository */
    private UserRepository $userRepo;
    /** @var AppRepository */
    private AppRepository $appRepo;
    /** @var PlansTypesRepository */
    private PlansTypesRepository $plansTypesRepo;

    /**
     * AccountPlan constructor.
     * @param AccountPlanService $accountPlan
     * @param Common $commonService
     * @param AppRepository $appRepo
     * @param AccountingTypeRepository $accountingTypeRepo
     * @param UserRepository $userRepo
     * @param PlansTypesRepository $plansTypesRepo
     */
    public function __construct(AccountPlanService $accountPlan, Common $commonService, AppRepository $appRepo,
                                AccountingTypeRepository $accountingTypeRepo, UserRepository $userRepo,
                                PlansTypesRepository $plansTypesRepo) {
        $this->appRepo            = $appRepo;
        $this->userRepo           = $userRepo;
        $this->accountPlan        = $accountPlan;
        $this->commonService      = $commonService;
        $this->plansTypesRepo     = $plansTypesRepo;
        $this->accountingTypeRepo = $accountingTypeRepo;
    }

    /**
     * @param GetPlans $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function index(GetPlans $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccounts = $this->commonService->findAll($objRequest->input("per_page", 10), $objRequest->only(["sort_plan", "sort_created_at"]));

        return ($this->apiReply($objAccounts, "", Response::HTTP_OK));
    }

    /**
     * @param string $service
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     */
    public function show(string $account){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccount = $this->commonService->find($account, false);

        if (is_null($objAccount)) {
            return ($this->apiReject(null, "Account not found.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->item($objAccount, new AccountTransformer(["user", "plans"])));
    }

    public function typeahead(TypeAheadRequest $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrFilters = $objRequest->only(["project", "artist", "account"]);
        $objAccounts = $this->commonService->typeahead($arrFilters);

        return ($this->apiReply($objAccounts, "", Response::HTTP_OK));
    }

    /**
     * @param CreateAccountPlan $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function store(CreateAccountPlan $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccount = $this->commonService->find($objRequest->input("account_uuid"));
        $objPlanType = $this->plansTypesRepo->find($objRequest->input("plan_type"));

        if (!empty($objAccount->plans()->where(["flag_active" => true]))) {
            return ($this->apiReject("", "Account already has active plan.", Response::HTTP_BAD_REQUEST));
        }

        $objAccountPlan = $this->accountPlan->create($objAccount, $objPlanType);

        Mail::to($objAccount->user->primary_email->user_auth_email)->send(new ServicePlanMail($this->appRepo->findOneByName("soundblock"), $objAccountPlan));

        return ($this->item($objAccountPlan, new AccountPlanTransformer));
    }

    /**
     * @param UpdateRenewalDay $objRequest
     * @param string $accountPlan
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function updateDay(UpdateRenewalDay $objRequest, string $accountPlan){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccountPlan = $this->accountPlan->find($accountPlan);
        $objAccountPlan = $this->accountPlan->updatePlanChargeDay($objAccountPlan, $objRequest->input("new_plan_date"));

        return ($this->apiReply($objAccountPlan, "Account plan renewal date updated successfully.", 200));
    }

    /**
     * @param ChangeAccountPlan $objRequest
     * @param string $user_uuid
     * @param string|null $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function changeAccountPlanType(ChangeAccountPlan $objRequest, string $user_uuid, string $account){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objPlanType = $this->plansTypesRepo->find($objRequest->input("account_plan_type"));
        $objUser = $this->userRepo->find($user_uuid);

        if (is_null($objUser)) {
            return ($this->apiReject(null, "User not found.", Response::HTTP_FORBIDDEN));
        }

        $objAccount = $this->commonService->find($account);

        if (is_null($objAccount)) {
            return ($this->apiReject(null, "Account not found.", Response::HTTP_FORBIDDEN));
        }

        if ($objUser->user_id !== $objAccount->user_id) {
            return $this->apiReject(null, "User doesn't own this account.", Response::HTTP_FORBIDDEN);
        }

        if (is_null($objUser->defaultPaymentMethod())){
            throw new \Exception("User doesn't have payment method.");
        }

        $objOldPlan = $this->accountPlan->getActivePlan($objAccount);
        $objAccount = $this->accountPlan->updateNew($objAccount, $objPlanType, $objOldPlan);

        return ($this->apiReply($objAccount->load("activePlan.planType"), "Account plan have been changed.", Response::HTTP_OK));
    }

    /**
     * @param string $account
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function cancel(string $account){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccount = $this->commonService->find($account);
        $this->accountPlan->cancelNew($objAccount);

        return ($this->apiReply(null, "Account plan canceled.", 200));
    }
}
