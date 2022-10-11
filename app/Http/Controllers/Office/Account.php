<?php

namespace App\Http\Controllers\Office;

use Auth;
use Mail;
use Illuminate\Http\Response;
use App\Services\Common\Common;
use App\Http\Controllers\Controller;
use App\Mail\Office\ServicePlan as ServicePlanMail;
use App\Http\Transformers\Account as AccountTransformer;
use App\Http\Requests\{
    Office\Account\Autocomplete,
    Soundblock\Account\CreateAccount,
    Soundblock\Account\UpdateAccount,
};
use App\Repositories\{
    Common\App as AppRepository,
    User\User as UserRepository,
    Soundblock\Data\PlansTypes as PlansTypesRepository
};

/**
 * @group Office Soundblock
 *
 */
class Account extends Controller {
    /** @var Common */
    private Common $commonService;
    /** @var UserRepository */
    private UserRepository $userRepo;
    /** @var AppRepository */
    private AppRepository $appRepo;
    /** @var PlansTypesRepository */
    private PlansTypesRepository $plansTypesRepo;

    /**
     * Account constructor.
     * @param Common $commonService
     * @param UserRepository $userRepo
     * @param AppRepository $appRepo
     * @param PlansTypesRepository $plansTypesRepo
     */
    public function __construct(Common $commonService, UserRepository $userRepo, AppRepository $appRepo,
                                PlansTypesRepository $plansTypesRepo) {
        $this->appRepo        = $appRepo;
        $this->userRepo       = $userRepo;
        $this->commonService  = $commonService;
        $this->plansTypesRepo = $plansTypesRepo;
    }

    /**
     * @param Autocomplete $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function autocomplete(Autocomplete $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $result = $this->commonService->autocomplete($objRequest->input("name"));

        if ($result) {
            return ($this->apiReply($result, "", 200));
        }

        return ($this->apiReject(null, "Accounts not found.", 400));
    }

    /**
     * @param CreateAccount $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function store(CreateAccount $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objUser = $this->userRepo->find($objRequest->input("user"));
        $objPlanType = $this->plansTypesRepo->find($objRequest->input("account_plan_type"));

        if (is_null($objUser->defaultPaymentMethod())){
            throw new \Exception("User doesn't have payment method.");
        }

        [$objAccount, $objAccountPlan] = $this->commonService->createNew($objRequest->input("account_name"), $objPlanType, $objUser);

        Mail::to($objAccount->user->primary_email->user_auth_email)->send(new ServicePlanMail($this->appRepo->findOneByName("soundblock"), $objAccountPlan));

        return ($this->apiReply($objAccount->load("activePlan.planType"), "Account Created Successfully.", Response::HTTP_OK));
    }

    /**
     * @param UpdateAccount $objRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccount $objRequest) {
        $objAccount = $this->commonService->find($objRequest->account);
        $objAccount = $this->commonService->update($objAccount, $objRequest->all());

        return ($this->item($objAccount, new AccountTransformer));
    }
}
