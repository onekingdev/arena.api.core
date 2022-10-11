<?php

namespace App\Http\Controllers\Soundblock;

use Auth;
use Constant;
use Exception;
use App\Services\{
    Soundblock\Project,
    Core\Auth\AuthGroup,
    Common\Common,
    Soundblock\Team as TeamService
};
use App\Models\Users\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Soundblock\ContractResource;
use App\Contracts\Soundblock\Contracts\SmartContracts;
use App\Http\Requests\Soundblock\Project\Contract\{CreateContract, SendReminders, UpdateContract};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Contract extends Controller {
    /** @var AuthGroup */
    protected AuthGroup $authGroupService;
    /** @var SmartContracts */
    private SmartContracts $smartContracts;
    /** @var Project */
    private Project $projectService;
    /** @var Common */
    private Common $commonService;
    /** @var TeamService */
    private TeamService $teamService;

    /**
     * Contract constructor.
     * @param AuthGroup $authGroupService
     * @param Project $projectService
     * @param SmartContracts $smartContracts
     * @param Common $commonService
     * @param TeamService $teamService
     */
    public function __construct(AuthGroup $authGroupService, Project $projectService, SmartContracts $smartContracts,
                                Common $commonService, TeamService $teamService) {
        $this->authGroupService = $authGroupService;
        $this->smartContracts = $smartContracts;
        $this->projectService = $projectService;
        $this->commonService = $commonService;
        $this->teamService = $teamService;
    }

    /**
     * @param string $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws Exception
     */
    public function get(string $project) {
        /** @var User $objUser */
        $objUser = Auth::user();
        $objUsersWithContractPerm = null;

        $objProject = $this->projectService->find($project, true);
        $strSoundGroup = sprintf("App.Soundblock.Project.%s", $project);
        $objGroup      = $this->authGroupService->findByName($strSoundGroup);

        if (!$this->commonService->checkIsAccountMember($objProject->account, $objUser) ||
            $this->authGroupService->checkIfUserExists($objUser, $objGroup) !== Constant::EXIST) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        /** @var Contract */
        $objContract = $this->smartContracts->findLatest($objProject, false);

        $objTeam = $this->teamService->findByProject($objProject->project_uuid);

        if (!empty($objTeam)) {
            $objUsersWithContractPerm = $this->teamService->findUsersWhereAccountPermission($objTeam, "App.Soundblock.Account.Project.Contract");
        }

        if (is_null($objContract)) {
            return ($this->apiReply(["contract_permission_users" => $objUsersWithContractPerm], "Project doesn't have contract.", 200));
        }


        if (strtolower($objContract->flag_status) === "voided") {
            return $this->apiReject($objContract, "Voided Contract.", 200);
        }

        if (!$this->smartContracts->checkAccess($objContract, $objUser) &&
            !$this->projectService->checkUserInProject($objProject->project_uuid, $objUser)) {
            abort(404);
        }
        $objContract = $this->smartContracts->getContractInfo($objContract);
        $objContract->contract_permission_users = $objUsersWithContractPerm;

        return($this->apiReply($objContract));
    }

    /**
     * @param string $project
     * @param CreateContract $objContractRequest
     * @return ContractResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function store(string $project, CreateContract $objContractRequest) {
        /** @var User $objUser */
        $objUser = Auth::user();

        $strGroupName = sprintf("App.Soundblock.Project.%s", $project);

        if (!is_authorized($objUser, $strGroupName, "App.Soundblock.Account.Project.Contract", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project, true);
        $objAccount = $objProject->account;
        $objProjectContracts = $objProject->contracts;

        if ($objProjectContracts->isEmpty()) {
            $objContract = $this->smartContracts->create($objProject, $objAccount, $objContractRequest->all());
        } else {
            if (!$this->projectService->checkUserInProject($objProject->project_uuid, $objUser)) {
                return ($this->apiReject(null, "Contract Not Found.", Response::HTTP_NOT_FOUND));
            }

            $objLatestContract = $this->smartContracts->findLatest($objProject);

            if (!$this->smartContracts->canModify($objLatestContract)) {
                return ($this->apiReject(null, "This Contract is Modifying Now.", Response::HTTP_BAD_REQUEST));
            }

            $objContract = $this->smartContracts->update($objLatestContract, $objContractRequest->all());
        }

        $objContract = $this->smartContracts->getContractInfo($objContract);

        return($this->apiReply($objContract));
    }

    /**
     * @param string $project
     * @param UpdateContract $objContractRequest
     * @return ContractResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function update(string $project, UpdateContract $objContractRequest) {
        /** @var User $objUser */
        $objUser = Auth::user();

        $strGroupName = sprintf("App.Soundblock.Project.%s", $project);

        if (!is_authorized($objUser, $strGroupName, "App.Soundblock.Account.Project.Contract", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project, true);

        if (!$this->projectService->checkUserInProject($objProject->project_uuid, $objUser)) {
            abort(404);
        }

        $objContract = $this->smartContracts->findLatest($objProject);
        $objContract = $this->smartContracts->update($objContract, $objContractRequest->all());

        return(new ContractResource($objContract));
    }

    /**
     * @param string $contract
     * @return ContractResource
     * @throws Exception
     */
    public function accept(string $contract) {
        try {
            /** @var User $objUser */
            $objUser = Auth::user();
            $objContract = $this->smartContracts->find($contract);
            $objUpdatedContract = $this->smartContracts->acceptContract($objContract, $objUser);

            return(new ContractResource($objUpdatedContract));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param string $contract
     * @return ContractResource
     * @throws Exception
     */
    public function reject(string $contract) {
        try {
            //TODO: Soundblock Permission?
            /** @var User $objUser */
            $objUser = Auth::user();
            $objContract = $this->smartContracts->find($contract);
            $objUpdatedContract = $this->smartContracts->rejectContract($objContract, $objUser);

            return(new ContractResource($objUpdatedContract));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param string $contract
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function cancel(string $contract) {
        /** @var User $objUser */
        $objUser = Auth::user();
        $objContract = $this->smartContracts->find($contract);

        $objProject = $objContract->project;

        $strGroupName = sprintf("App.Soundblock.Project.%s", $objProject->project_uuid);

        if (!is_authorized($objUser, $strGroupName, "App.Soundblock.Account.Project.Contract", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        try {
            $objContract = $this->smartContracts->cancelContract($objContract, $objUser);
        } catch (\Exception $exception) {
            return $this->apiReject(null, $exception->getMessage(), $exception->getCode());
        }

        return $this->apiReply($objContract, "Contract Successfully Canceled.x");

    }

    /**
     * @param string $project
     * @param SendReminders $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function sendReminders(string $project, SendReminders $objRequest){
        /** @var User $objUser */
        $objUser = Auth::user();

        $strGroupName = sprintf("App.Soundblock.Project.%s", $project);

        if (!is_authorized($objUser, $strGroupName, "App.Soundblock.Account.Project.Contract", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project, true);

        if (!$this->projectService->checkUserInProject($objProject->project_uuid, $objUser)) {
            abort(404);
        }

        $objContract = $this->smartContracts->findLatest($objProject);
        $this->smartContracts->sendReminders($objContract, $objRequest->only(["user_uuid", "invite_uuid"]));

        return ($this->apiReply(null, "Reminders sent successfully.", 200));
    }
}
