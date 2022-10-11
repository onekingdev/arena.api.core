<?php

namespace App\Http\Controllers\Office;

use Client;
use App\Models\Soundblock\Invites;
use App\Models\Users\User as UserModel;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Http\{
    Controllers\Controller,
    Resources\Soundblock\InviteResource,
    Transformers\User\User as UserTransformer,
};
use App\Services\{
    User,
    Core\Auth\AuthGroup,
    Core\Auth\AuthPermission,
    Soundblock\Team as TeamService,
    Soundblock\Project as ProjectService,
};
use App\Http\Requests\{Office\Project\AddMember,
    Office\Project\Autocomplete,
    Office\Project\AddFile,
    Office\Project\GetProjects,
    Office\Project\CreateMember,
    Office\TypeAheads\Project as TypeAhead,
    Soundblock\Project\ConfirmFiles,
    Soundblock\Project\UploadArtwork,
    Office\Project\CreateProject as CreateProjectRequestForOffice};

/**
 * @group Office Soundblock
 *
 */
class Project extends Controller {
    /** @var ProjectService */
    protected ProjectService $projectService;
    /** @var AuthGroup */
    protected AuthGroup $authGroupService;
    /** @var User */
    private User $userService;
    /** @var TeamService */
    private TeamService $teamService;
    /** @var AuthPermission */
    private AuthPermission $authPermService;

    /**
     * Project constructor.
     * @param ProjectService $projectService
     * @param AuthGroup $authGroupService
     * @param User $userService
     * @param TeamService $teamService
     * @param AuthPermission $authPermService
     */
    public function __construct(ProjectService $projectService, AuthGroup $authGroupService,
                                User $userService, TeamService $teamService, AuthPermission $authPermService) {
        $this->projectService = $projectService;
        $this->authGroupService = $authGroupService;
        $this->userService = $userService;
        $this->teamService = $teamService;
        $this->authPermService = $authPermService;
    }

    /**
     * @param GetProjects $objRequest
     * @return object
     * @throws \Exception
     */
    public function index(GetProjects $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrSort = $objRequest->only(["sort_name", "sort_type", "sort_created_at"]);
        $perPage = $objRequest->input("per_page", 10);

        [$arrProject, $availableMetaData] = $this->projectService->findAll($objRequest->all(), $perPage, $arrSort);

        return ($this->apiReply($arrProject->load("artist", "format", "artists", "primaryGenre", "secondaryGenre", "language"), "", Response::HTTP_OK, $availableMetaData));
    }

    /**
     * @param string $project
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function show(string $project) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project);

        return ($this->apiReply($objProject->load("deployments", "team", "account")));
    }

    /**
     * @param $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getMembers(string $project) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objUsers = $this->projectService->getUsers($project);

        return ($this->collection($objUsers, new UserTransformer()));
    }

    /**
     * @param Autocomplete $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function autocomplete(Autocomplete $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $result = $this->projectService->autocomplete($objRequest->input("name"));

        if ($result) {
            return ($this->apiReply($result, "", 200));
        }

        return ($this->apiReject(null, "Projects not found.", 400));
    }

    /**
     * @param Autocomplete $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function autocompleteWithAccounts(Autocomplete $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $result = $this->projectService->autocompleteWithAccounts($objRequest->input("name"));

        if ($result) {
            return ($this->apiReply($result, "", 200));
        }

        return ($this->apiReject(null, "Projects not found.", 400));
    }

    public function typeahead(TypeAhead $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrFilters = $objRequest->only(["project", "artist", "account", "artists"]);
        $objProjects = $this->projectService->typeahead($arrFilters);

        return ($this->apiReply($objProjects, "", Response::HTTP_OK));
    }

    /**
     * @param CreateProjectRequestForOffice $objRequest
     * @return InviteResource|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function store(CreateProjectRequestForOffice $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->projectService->create($objRequest->all());

        if ($objRequest->has("members")) {
            foreach ($objRequest->input("members") as $member) {
                $member["team"] = $objProject->team->team_uuid;
                $objMember = $this->teamService->storeMember($member);

                if ($objMember instanceof UserModel) {
                    $this->authPermService->updateProjectGroupPermissions($member["permissions"], $objMember, $objProject);
                }
            }
        }

        return ($this->apiReply($objProject, "Project created successfully", Response::HTTP_OK));
    }

    /**
     * @param AddFile $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function addFile(AddFile $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->addFile($objRequest->all());

        return ($this->apiReply($objProject));
    }

    /**
     * @param ConfirmFiles $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function confirm(ConfirmFiles $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objQueueJob = $this->projectService->confirm($objRequest->all());

        return ($this->apiReply($objQueueJob));
    }

    /**
     * @param UploadArtwork $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     *
     * @throws \Exception
     */
    public function artwork(UploadArtwork $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($objRequest->project);
        $objProject = $this->projectService->uploadArtwork($objProject, $objRequest->artwork);

        return ($this->apiReply($objProject->append("artwork")));
    }

    /**
     * @param AddMember $request
     * @param string $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function addMember(AddMember $request, string $project) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        /** @var \App\Models\Soundblock\Projects\Project $objProject */
        $objProject = $this->projectService->find($project);

        $objInvited = $this->teamService->storeMember([
            "user_uuid" => $request->input("user"),
            "user_role_id" => $request->input("user_role_id"),
            "team"      => $objProject->team,
        ]);

        if ($request->has("permissions") && $objInvited instanceof UserModel) {
            $this->authPermService->updateProjectAndAccountGroupPermissions($request->permissions, $objInvited, $objProject, Client::app());
        }

        $objUsers = $this->projectService->getUsers($project);

        return ($this->collection($objUsers, new UserTransformer()));
    }

    /**
     * @param CreateMember $objRequest
     * @param string $project
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function createMember(CreateMember $objRequest, string $project) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->projectService->find($project, true);
        $objInvited = $this->teamService->storeMember($objRequest->all());

        if ($objInvited instanceof Invites) {
            return (new InviteResource($objInvited));
        }

        $objInvited = $this->authPermService->updateProjectGroupPermissions($objRequest->permissions, $objInvited, $objProject);

        return ($this->apiReply($objInvited, "", 200));
    }

    /**
     * @param Request $objRequest
     * @param string $project
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function updateLabel(Request $objRequest, string $project) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objProject = $this->projectService->find($project);
        $objProject = $this->projectService->update(
            $objProject,
            ["label" => $objRequest->input("label")]
        );

        return ($this->apiReply($objProject->load("deployments", "team")));
    }

    /**
     * @param string $project
     * @param string $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteMember(string $project, string $user) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $strProjectGroup = sprintf("App.Soundblock.Project.%s", $project);
        $objGroup = $this->authGroupService->findByName($strProjectGroup);
        $objUser = $this->userService->findAllWhere([$user]);
        $this->authGroupService->detachUsersFromGroup($objUser, $objGroup);
        $objUsers = $this->projectService->getUsers($project);

        return ($this->collection($objUsers, new UserTransformer()));
    }
}
