<?php

namespace App\Http\Controllers\Account;

use App\Models\Users\User;
use App\Http\Transformers\{
    Account,
    Soundblock\Team,
    Soundblock\Deployment,
    Soundblock\Transaction,
    Soundblock\AccountPlan,
    User\User as UserTransformer,
    Account\Project as ProjectTransformer,
};
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Traits\Account\FindUserProject;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Http\Requests\Account\Soundblock\GetProjects;
use App\Services\{Auth, Common\Common, Soundblock\Project};

/**
 * @group Account
 *
 */
class Soundblock extends Controller {
    use FindUserProject;

    /**
     * @var Auth
     */
    private Auth $authService;
    /**
     * @var Project
     */
    private Project $projectService;

    /**
     * Soundblock constructor.
     * @param Auth $authService
     * @param Project $projectService
     */
    public function __construct(Auth $authService, Project $projectService) {
        $this->authService = $authService;
        $this->projectService = $projectService;
    }

    /**
     * @param GetProjects $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getProjects(GetProjects $objRequest) {
        /** @var User $objUser */
        $objUser = AuthFacade::user();

        if (!is_authorized($objUser, "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        if ($objRequest->has('per_page')) {
            $perPage = $objRequest->input('per_page');
        } else {
            $perPage = 10;
        }

        $objProjects = $this->projectService->findAllByUser($perPage, $objUser);

        return ($this->paginator($objProjects, new ProjectTransformer));
    }

    /**
     * @param $strProjectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProject($strProjectUuid) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->getUserProject($strProjectUuid);

        return ($this->item($objProject, new ProjectTransformer));
    }

    /**
     * @param $strProjectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjectDeployments($strProjectUuid) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->getUserProject($strProjectUuid);

        return ($this->item($objProject->deployments, new Deployment));
    }

    /**
     * @param $strProjectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjectAccount($strProjectUuid) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->getUserProject($strProjectUuid);

        return ($this->item($objProject->account, new Account(["plans"])));
    }

    /**
     * @param $strProjectUuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProjectMembers($strProjectUuid) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->getUserProject($strProjectUuid);

        return ($this->item($objProject->team, new Team(["users"])));
    }

    /**
     * @param Common $commonService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccounts(Common $commonService) {
        /** @var User $objUser */
        $objUser = AuthFacade::user();

        if (!is_authorized($objUser, "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $arrAccounts = $commonService->findByUser($objUser);

        return ($this->collection($arrAccounts, new Account));
    }

    /**
     * @param $strAccountUuid
     * @param Common $commonService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccount($strAccountUuid, Common $commonService) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objAccount = $this->getUsersAccount($strAccountUuid, $commonService);

        return ($this->item($objAccount, new Account));
    }

    /**
     * @param $strServiceUuid
     * @param Common $commonService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getAccountTransaction($strServiceUuid, Common $commonService) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objAccount = $this->getUsersAccount($strServiceUuid, $commonService);

        return ($this->item($objAccount->transactions, new Transaction));
    }

    /**
     * @param $strAccountUuid
     * @param Common $commonService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function getAccountPlan($strAccountUuid, Common $commonService) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objAccount = $this->getUsersAccount($strAccountUuid, $commonService);

        $objPlan = $objAccount->plans()->active()->first();

        if (is_null($objPlan)) {
            return $this->apiReject("", "Account doesn't have active plan.", Response::HTTP_NOT_FOUND);
        }

        return ($this->item($objPlan, new AccountPlan()));
    }

    /**
     * @param $strAccountUuid
     * @param Common $commonService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function getAccountUser($strAccountUuid, Common $commonService) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objAccount = $this->getUsersAccount($strAccountUuid, $commonService);

        return ($this->item($objAccount->user, new UserTransformer));
    }
}
