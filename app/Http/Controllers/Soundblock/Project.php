<?php

namespace App\Http\Controllers\Soundblock;

use Util;
use Client;
use Constant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Helpers\Filesystem\Soundblock;
use League\Flysystem\FileNotFoundException;
use App\Jobs\Soundblock\Projects\ProjectUpc;
use App\Jobs\Soundblock\Ledger\ProjectLedger;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Http\Transformers\Soundblock\{
    File,
    ProjectAccounts
};
use App\Models\{
    Users\User as UserModel,
    Soundblock\Collections\Collection
};
use App\Contracts\Soundblock\{
    Audit\Bandwidth,
    Contracts\SmartContracts
};
use App\Services\{
    Common\Common,
    Common\AccountPlan as AccountPlanService,
    Core\Auth\AuthGroup,
    Soundblock\Deployment,
    Soundblock\Project as ProjectService,
    Soundblock\Collection as CollectionService
};
use App\Http\Requests\{Office\Project\AddFile,
    Soundblock\Project\ConfirmFiles,
    Soundblock\Project\DetachProjects,
    Soundblock\Project\UpdateProject,
    Soundblock\Project\UploadArtwork,
    Soundblock\Project\CreateProject,
    Soundblock\Project\PingExtractingZip,
    Soundblock\Project\Draft\UploadDraftArtwork};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Project extends Controller {
    /** @var ProjectService */
    protected ProjectService $projectService;
    /** @var AuthGroup */
    protected AuthGroup $authGroupService;
    /** @var Common */
    private Common $commonService;
    /** @var SmartContracts */
    private SmartContracts $smartContract;
    /** @var Deployment */
    private Deployment $deploymentService;
    /** @var CollectionService */
    private CollectionService $collectionService;
    private AccountPlanService $objPlanService;
    /** @var Bandwidth */
    private Bandwidth $bandwidthService;

    /**
     * Project constructor.
     * @param ProjectService $projectService
     * @param AuthGroup $authGroupService
     * @param Common $commonService
     * @param Deployment $deploymentService
     * @param SmartContracts $smartContract
     * @param CollectionService $collectionService
     * @param AccountPlanService $objPlanService
     * @param Bandwidth $bandwidthService
     */
    public function __construct(ProjectService $projectService, AuthGroup $authGroupService, Common $commonService,
                                Deployment $deploymentService, SmartContracts $smartContract, CollectionService $collectionService,
                                AccountPlanService $objPlanService, Bandwidth $bandwidthService) {
        $this->projectService = $projectService;
        $this->authGroupService = $authGroupService;
        $this->commonService = $commonService;
        $this->smartContract = $smartContract;
        $this->deploymentService = $deploymentService;
        $this->collectionService = $collectionService;
        $this->objPlanService = $objPlanService;
        $this->bandwidthService = $bandwidthService;
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response|object
     * @throws Exception
     */
    public function index(Request $request) {
        /** @var UserModel $objUser */
        $objUser = AuthFacade::user();
        $arrProject = $this->projectService->findAllByUser($request->input("per_page", 10), $objUser, $request->input("sort_by", "last_update"));

        return ($this->apiReply($arrProject, "", 200));
    }

    public function getProjectsByAccount(string $account) {
        /** @var UserModel $objUser*/
        $objUser = AuthFacade::user();
        /** @var \App\Models\Soundblock\Accounts\Account $objAccount */
        $objAccount = $this->commonService->find($account);

        if (!$this->commonService->checkIsAccountMember($objAccount, $objUser)) {
            return $this->apiReject(null, "Forbidden.", Response::HTTP_FORBIDDEN);
        }

        $arrProjects = $this->projectService->findByAccountAndUser($objAccount, $objUser);

        return $this->apiReply($arrProjects);
    }

    /**
     * @return ResponseFactory|Response|object
     */
    public function getProjectsAccounts(){
        /** @var UserModel $objUser*/
        $objUser = AuthFacade::user();
        $objServicesProjects = $this->projectService->findAllByUserWithAccounts($objUser);
        $objServicesProjects = $objUser->userAccounts->merge($objServicesProjects);

        return ($this->collection($objServicesProjects, new ProjectAccounts));
    }

    public function getProjectsRoles() {
        $objRoles = $this->projectService->getRoles();

        return $this->apiReply($objRoles);
    }

    public function getProjectsFormats() {
        $objTypes = $this->projectService->getFormats();

        return $this->apiReply($objTypes);
    }

    /**
     * @param string $project
     * @return Application|ResponseFactory|Response|object
     * @throws Exception
     */
    public function show(string $project) {
        /** @var UserModel $objUser*/
        $objUser       = AuthFacade::user();
        $strSoundGroup = sprintf("App.Soundblock.Project.%s", $project);
        $objGroup      = $this->authGroupService->findByName($strSoundGroup);
        $objProject    = $this->projectService->find($project);

        $objAccount = $objProject->account;

        if (is_null($objAccount)) {
            return ($this->apiReject("", "Invalid Project's Account.", Response::HTTP_BAD_REQUEST));
        }

        if (
            $this->authGroupService->checkIfUserExists($objUser, $objGroup) !== Constant::EXIST ||
            !$this->commonService->checkIsAccountMember($objAccount, $objUser)
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        /** @var Collection */
        $objLatestCollection = $this->collectionService->findLatestByProject($objProject);

        if ($objLatestCollection) {
            /** @var \Illuminate\Database\Eloquent\Collection */
            $tracksForLatestCollection = $this->collectionService->getOrderedTracks($objLatestCollection);
            $objProject->tracks = $tracksForLatestCollection;
        }

        $projectStatus = [];

        /** @var \App\Models\Soundblock\Projects\Contracts\Contract $contract*/
        $contract = $this->smartContract->findLatest($objProject, false);

        $lastDeployment = $this->deploymentService->findLatest($objProject);

        if (is_null($lastDeployment)) {
            $projectStatus["deployment"] = null;
        } else {
            $projectStatus["deployment"] = $lastDeployment->only("deployment_status");
        }

        $projectStatus["exists_collection"] = $objProject->collections()->exists();

        if (is_object($contract)) {
            $contract->load(["users" => function ($query) use ($contract) {
                $query->where("soundblock_projects_contracts_users.contract_version", $contract->contract_version)
                    ->select("soundblock_projects_contracts_users.contract_status", "users.*");
            }]);

            $contractUsers = $contract->users->map(function ($item) {
                return ($item->only("name", "contract_status"));
            });
            unset($contract->users);
            $contract->users = $contractUsers;
            $projectStatus["contract"] = $contract->only("users", "invites", "flag_status");
        } else {
            $projectStatus["contract"] = null;
        }

        if (count($objProject->team->users()->where("soundblock_projects_teams_users.user_role", "!=", "Owner")->get()) == 0) {
            $projectStatus["flag_team"] = false;
        } else {
            $projectStatus["flag_team"] = true;
        }

        $projectStatus["team_uuid"] = $objProject->team->team_uuid;

        $objProject->status = $projectStatus;
        $objProject->unsetRelation("team");

        return ($this->apiReply($objProject->load("artist", "format", "artists", "primaryGenre", "secondaryGenre", "language")));
    }


    public function getArtwork(string $project) {
        $objProject = $this->projectService->find($project);

        if (is_null($objProject)) {
            return $this->apiReject(null, "Project Not Found.", Response::HTTP_NOT_FOUND);
        }

        $filePath = Soundblock::upload_project_artwork_path($objProject);

        return bucket_storage("soundblock")->download($filePath);
    }

    /**
     * @param CreateProject $objRequest
     * @return Application|ResponseFactory|Response|object
     * @throws Exception
     * @throws FileNotFoundException
     */
    public function store(CreateProject $objRequest) {
        $strGroupName = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));
        /** @var UserModel $objUser */
        $objUser = AuthFacade::user();

        if (!is_authorized($objUser, $strGroupName, "App.Soundblock.Account.Project.Create", "soundblock", true, true)) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAccount = $this->commonService->find($objRequest->input("account"));

        if (is_null($objAccount)) {
            return $this->apiReject(null, "Invalid Account.", Response::HTTP_BAD_REQUEST);
        }

        $objPlan = $this->objPlanService->getActivePlan($objAccount);

        if (is_null($objPlan)) {
            return $this->apiReject(null, "User Doesn't Have Active Plan.", Response::HTTP_BAD_REQUEST);
        }

        $objProject = $this->projectService->create($objRequest->all());

        dispatch(new ProjectLedger($objProject, \App\Services\Soundblock\Ledger\ProjectLedger::CREATE_EVENT))->onQueue("ledger");

        return ($this->apiReply($objProject));
    }

    /**
     * @param AddFile $objRequest
     * @return Application|ResponseFactory|Response|object
     * @throws Exception
     */
    public function addFile(AddFile $objRequest) {
        $strSoundGroup = $this->authGroupService->findByProject($objRequest->project)->group_name;

        if (!is_authorized(AuthFacade::user(), $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->addFile($objRequest->all());

        return ($this->apiReply($objProject));
    }

    /**
     * @param string $project
     * @param UpdateProject $objRequest
     * @return mixed
     * @throws Exception
     */
    public function update(string $project, UpdateProject $objRequest) {
        $objUser           = AuthFacade::user();
        $strSoundGroup     = sprintf("App.Soundblock.Project.%s", $project);
        $bnSoundblock      = is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock");
        $objProject        = $this->projectService->find($project);
        $bnExistsInService = $this->commonService->checkIsAccountMember($objProject->account, $objUser);

        if (!$bnSoundblock || !$bnExistsInService) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->update($objProject, $objRequest->all());
        $projectStatus = [];

        /** @var \App\Models\Soundblock\Projects\Contracts\Contract $contract*/
        $contract = $this->smartContract->findLatest($objProject, false);
        $lastDeployment = $this->deploymentService->findLatest($objProject);

        if (is_null($lastDeployment)) {
            $projectStatus["deployment"] = null;
        } else {
            $projectStatus["deployment"] = $lastDeployment->only("deployment_status");
        }

        $projectStatus["exists_collection"] = $objProject->collections()->exists();

        if (is_object($contract)) {
            $contract->load(["users" => function ($query) use ($contract) {
                $query->where("soundblock_projects_contracts_users.contract_version", $contract->contract_version)
                      ->select("soundblock_projects_contracts_users.contract_status", "users.*");
            }]);

            $contractUsers = $contract->users->map(function ($item) {
                return ($item->only("name", "contract_status"));
            });
            unset($contract->users);
            $contract->users = $contractUsers;
            $projectStatus["contract"] = $contract->only("users", "invites", "flag_status");
        } else {
            $projectStatus["contract"] = null;
        }

        $objProject->status = $projectStatus;
        dispatch(new ProjectLedger($objProject, \App\Services\Soundblock\Ledger\ProjectLedger::UPDATE_EVENT))->onQueue("ledger");

        return ($this->apiReply($objProject));
    }

    /**
     * @param ConfirmFiles $objRequest
     * @return Application|ResponseFactory|Response|object
     * @throws Exception
     */
    public function confirm(ConfirmFiles $objRequest) {
        $strSoundGroup = $this->authGroupService->findByProject($objRequest->project)->group_name;

        if (!is_authorized(AuthFacade::user(), $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objQueueJob = $this->projectService->confirm($objRequest->all());

        return ($this->apiReply($objQueueJob));
    }

    /**
     * @param UploadArtwork $objRequest
     * @return Application|ResponseFactory|Response|object
     * @throws Exception
     */
    public function artwork(UploadArtwork $objRequest) {
        $objUser           = AuthFacade::user();
        $strSoundGroup     = $this->authGroupService->findByProject($objRequest->project)->group_name;
        $objProject        = $this->projectService->find($objRequest->project);
        $bnSoundblock      = is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true);
        $bnExistsInService = $this->commonService->checkIsAccountMember($objProject->account, $objUser);

        if (!$bnSoundblock || !$bnExistsInService) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $this->bandwidthService->create($objProject, AuthFacade::user(), $objRequest->file("artwork")->getSize(), Bandwidth::UPLOAD);
        $objProject = $this->projectService->uploadArtwork($objProject, $objRequest->artwork);
        dispatch(new ProjectLedger($objProject, \App\Services\Soundblock\Ledger\ProjectLedger::UPDATE_EVENT))->onQueue("ledger");

        return ($this->apiReply($objProject->load("artist", "artists")));
    }

    /**
     * @param UploadDraftArtwork $objRequest
     * @return Application|ResponseFactory|Response|object
     * @throws Exception
     */
    public function uploadArtworkForDraft(UploadDraftArtwork $objRequest) {
        try {
            $fileName = $this->projectService->uploadArtworkForDraft($objRequest->artwork);
            $cdnUrl = Util::draft_artwork_cdn_url($fileName);

            return ($this->apiReply([
                "artwork" => $cdnUrl,
            ]));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param PingExtractingZip $objRequest
     * @return JsonResponse
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function pingExtractingZip(PingExtractingZip $objRequest) {
        try {
            $arrObjFiles = $this->projectService->pingExtractingZip($objRequest->all());

            return ($this->collection($arrObjFiles, new File));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param DetachProjects $objRequest
     * @return ResponseFactory|Response|object
     * @throws Exception
     */
    public function detachUser(DetachProjects $objRequest){
        $objUser = AuthFacade::user();

        $boolResult = $this->projectService->detachUserFromProjects($objUser, $objRequest->account, [$objRequest->project]);

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", 400));
        }

        return ($this->apiReply(null, "User detached successfully.", 200));
    }
}
