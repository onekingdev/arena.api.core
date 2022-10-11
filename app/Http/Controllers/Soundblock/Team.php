<?php

namespace App\Http\Controllers\Soundblock;

use Client;
use Constant;
use Exception;
use App\Models\Users\User;
use Illuminate\Http\Response;
use App\Models\Soundblock\Invites;
use App\Http\Controllers\Controller;
use App\Http\Resources\Soundblock\InviteResource;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Contracts\Soundblock\Invite\Invite as InviteContract;
use App\Events\Soundblock\{
    UpdateTeam,
    UpdateTeamPermission
};
use App\Repositories\{
    Soundblock\Invite as InviteRepository,
    Soundblock\Team as TeamRepository,
    User\User as UserRepository
};
use App\Services\{
    Common\Common as CommonService,
    Soundblock\Project,
    Core\Auth\AuthGroup,
    User as UserService,
    Core\Auth\AuthPermission,
    Soundblock\Team as TeamService,
    Soundblock\Invite as InviteService
};
use App\Http\Requests\Soundblock\{
    Project\Team\AddTeamMember,
    Project\Team\SendRemind,
    Project\Team\UpdatePermission,
    Project\Team\DeleteMembers,
    Project\Team\Update as UpdateTeamRequest,
    Project\Team\UpdateRole
};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Team extends Controller {
    /** @var AuthGroup */
    protected AuthGroup $authGroupService;
    /** @var AuthPermission */
    protected AuthPermission $authPermService;
    /** @var Project */
    private Project $projectService;
    /** @var TeamService */
    private TeamService $teamService;
    /** @var UserRepository */
    private UserRepository $userRepo;
    /** @var UserService */
    private UserService $userService;
    /** @var InviteRepository */
    private InviteRepository $inviteRepo;
    /** @var InviteContract */
    private InviteContract $inviteContract;
    /** @var CommonService */
    private CommonService $commonService;
    /** @var TeamRepository */
    private TeamRepository $teamRepo;
    /** @var InviteService */
    private InviteService $inviteService;

    /**
     * @param AuthGroup $authGroupService
     * @param AuthPermission $authPermService
     * @param Project $projectService
     * @param TeamService $teamService
     * @param UserRepository $userRepo
     * @param UserService $userService
     * @param InviteRepository $inviteRepo
     * @param InviteContract $inviteContract
     * @param CommonService $commonService
     * @param TeamRepository $teamRepo
     * @param InviteService $inviteService
     */
    public function __construct(AuthGroup $authGroupService, AuthPermission $authPermService, Project $projectService,
                                TeamService $teamService, UserRepository $userRepo, UserService $userService,
                                InviteRepository $inviteRepo, InviteContract $inviteContract, CommonService $commonService,
                                TeamRepository $teamRepo, InviteService $inviteService) {
        $this->userRepo = $userRepo;
        $this->inviteRepo = $inviteRepo;
        $this->teamService = $teamService;
        $this->userService = $userService;
        $this->inviteContract = $inviteContract;
        $this->projectService = $projectService;
        $this->authPermService = $authPermService;
        $this->authGroupService = $authGroupService;
        $this->commonService = $commonService;
        $this->teamRepo = $teamRepo;
        $this->inviteService = $inviteService;
    }

    /**
     * @param string $team
     * @param string $user
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function getPermissions(string $team, string $user) {
        $objProject = $this->teamService->find($team, true)->project;
        $strGroup = "App.Soundblock.Project.{$objProject->project_uuid}";
        $objGroup = $this->authGroupService->findByName($strGroup);

        if (!$this->authGroupService->checkIfUserExists(AuthFacade::user(), $objGroup)) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objUser = $this->userRepo->find($user);

        if ($objUser) {
            $projectGroup = $this->authGroupService->findByProject($objProject);
            $accountGroup = $this->authGroupService->findByAccount($objProject->account);
            $arrProjectPermission = $this->authPermService->findAllUserPermissionsByGroup($projectGroup, $objUser)->toArray();
            $arrAccountPermission = $this->authPermService->findAllUserPermissionsByGroup($accountGroup, $objUser)->toArray();
            $arrPermission = array_merge($arrAccountPermission, $arrProjectPermission);
            $arrPermission = array_values(array_map("unserialize", array_unique(array_map("serialize", $arrPermission))));

            return ($this->apiReply($arrPermission, "", 200));
        }

        return ($this->apiReject(null, "User not found.", 400));
    }

    /**
     * @param string $team
     * @param string $invite
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getInvitePermissions(string $team, string $invite) {
        $project = $this->teamService->find($team, true)->project;
        $strGroup = "App.Soundblock.Project.{$project->project_uuid}";

        if (!is_authorized(AuthFacade::user(), $strGroup, "App.Soundblock.Project.Member.Permissions", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objInvite = $this->inviteRepo->find($invite);

        if ($objInvite) {
            return ($this->apiReply($objInvite->invite_permissions, "", 200));
        }

        return ($this->apiReject(null, "Invite not found.", 400));
    }

    /**
     * @param string $project
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws Exception
     */
    public function show(string $project) {
        $objGroup = $this->authGroupService->findByProject($project);
        $objProject = $this->projectService->find($project, true);

        if (
            $this->authGroupService->checkIfUserExists(AuthFacade::user(), $objGroup) !== Constant::EXIST ||
            !$this->commonService->checkIsAccountMember($objProject->account, AuthFacade::user())
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->findByProject($objProject);
        $objTeam = $this->teamService->getUsers($objProject);

        return ($this->apiReply([
            "permissions_in_team" => $objAuthGroup->permissions()->select(
                "core_auth_permissions.permission_uuid",
                "core_auth_permissions.permission_name",
                "core_auth_permissions.permission_memo",
                "core_auth_permissions_groups.permission_value"
            )->get(),
            "team"                => $objTeam,
        ]));
    }

    /**
     * @param AddTeamMember $objRequest
     *
     * @return InviteResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function storeMember(AddTeamMember $objRequest) {
        $objApp = Client::app();
        $objProject = $this->teamService->find($objRequest->team, true)->project;

        $strGroup = "App.Soundblock.Project.{$objProject->project_uuid}";

        if (!is_authorized(AuthFacade::user(), $strGroup, "App.Soundblock.Project.Member.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objInvited = $this->teamService->storeMember($objRequest->all());

        if ($objInvited instanceof Invites) {
            event(new UpdateTeam($objProject));

            return (new InviteResource($objInvited->load("role")));
        }

        if ($objRequest->has("permissions")) {
            $objInvited = $this->authPermService->updateProjectAndAccountGroupPermissions($objRequest->permissions, $objInvited, $objProject, $objApp);
        }

        event(new UpdateTeam($objProject));

        return ($this->apiReply($objInvited, "", 200));
    }

    /**
     * @param string $team
     * @param string $user
     * @param UpdatePermission $objRequest
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function updatePermissions(string $team, string $user, UpdatePermission $objRequest) {
        $objApp = Client::app();
        $objUser = $this->userService->find($user, true);
        $objProject = $this->teamService->find($team, true)->project;
        $strGroup = "App.Soundblock.Project.{$objProject->project_uuid}";

        if (!is_authorized(AuthFacade::user(), $strGroup, "App.Soundblock.Project.Member.Permissions", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->findByProject($objProject);
        $objUser = $this->authPermService->updateProjectAndAccountGroupPermissions($objRequest->permissions, $objUser, $objProject, $objApp);
        $permissions = $this->authPermService->findAllUserPermissionsByGroup($objAuthGroup, $objUser);

        event(new UpdateTeamPermission($objProject, $objUser));

        return ($this->apiReply(["permissions_in_team" => $permissions]));
    }

    /**
     * @param string $team
     * @param string $user
     * @param UpdateRole $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function updateRole(string $team, string $user, UpdateRole $objRequest){
        $objUser = $this->userRepo->find($user);

        if (is_null($objUser)) {
            $objInvite = $this->inviteRepo->find($user, true);
        }

        $objTeam = $this->teamService->find($team, true);
        $strGroup = "App.Soundblock.Project.{$objTeam->project->project_uuid}";

        if (!is_authorized(AuthFacade::user(), $strGroup, "App.Soundblock.Project.Member.Permissions", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if ($objUser) {
            $objTeam = $this->teamRepo->updateUserRole($objTeam, $objUser, $objRequest->only("role", "user_role_id"));
            event(new UpdateTeam($objTeam->project));
        } elseif (isset($objInvite)) {
            $objInvite = $this->inviteService->updateInviteRole($objInvite, $objRequest->input("user_role_id"));
        } else {
            return ($this->apiReject(null, "Invalid parameters.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply($objTeam, "User Role updated successfully.", 200));
    }

    /**
     * @param string $team
     * @param string $invite
     * @param UpdatePermission $objRequest
     * @return mixed
     * @throws Exception
     */
    public function updateInvitePermissions(string $team, string $invite, UpdatePermission $objRequest) {
        $objInvite = $this->inviteRepo->find($invite, true);
        $project = $this->teamService->find($team, true)->project;
        $strGroup = "App.Soundblock.Project.{$project->project_uuid}";

        if (!is_authorized(AuthFacade::user(), $strGroup, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objInvite = $this->inviteContract->updateInvitePermissions($objInvite, $objRequest->only("permissions"));
        event(new UpdateTeam($project));

        return ($this->apiReply($objInvite, "Permissions updated successfully.", 200));
    }

    /**
     * @param UpdateTeamRequest $updateTeamRequest
     * @param string $team
     * @return mixed
     * @throws Exception
     */
    public function update(UpdateTeamRequest $updateTeamRequest, string $team) {
        $objTeam = $this->teamService->find($team, true);
        $objProject = $objTeam->project;
        /** @var User $objUser */
        $objUser = AuthFacade::user();

        $strGroup = "App.Soundblock.Project.{$objProject->project_uuid}";

        if (!is_authorized($objUser, $strGroup, "App.Soundblock.Account.Project.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTeamMembers = $this->teamService->update($objTeam, $updateTeamRequest->input("users"));

        event(new UpdateTeam($objProject));

        return ($this->apiReply($objTeamMembers, "Team updated successfully.", 200));
    }

    /**
     * @param SendRemind $objRequest
     * @param string $project
     * @return mixed
     * @throws Exception
     */
    public function remind(SendRemind $objRequest, string $project) {
        $objUser = AuthFacade::user();
        $strGroupName = sprintf("App.Soundblock.Project.%s", $project);

        if (!is_authorized($objUser, $strGroupName, "App.Soundblock.Project.Member.Create", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProject = $this->projectService->find($project, true);

        if (!$this->projectService->checkUserInProject($objProject->project_uuid, $objUser)) {
            abort(404);
        }

        $boolResult = $this->teamService->remind($objProject, $objRequest->all());

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", 400));
        }

        event(new UpdateTeam($objProject));

        return ($this->apiReply(null, "Reminder sent successfully.", 200));
    }

    /**
     * @param $project
     * @param $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function deleteMember($project, $user) {
        $strProjectGroup = sprintf("App.Soundblock.Project.%s", $project);

        if (!is_authorized(AuthFacade::user(), $strProjectGroup, "App.Soundblock.Project.Member.Delete", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objGroup = $this->authGroupService->findByName($strProjectGroup);
        $objUser = $this->userService->findAllWhere([$user]);
        $objProject = $this->projectService->find($project);

        if (count($objUser) > 0) {
            $this->teamService->delete($objProject, $objUser, $objGroup);

            event(new UpdateTeam($objProject));

            return ($this->apiReply(null, "Deleted member", 204));
        } else {
            $objInvite = $this->teamService->getInvite($objProject, $user);

            if (is_object($objInvite)) {
                $this->inviteContract->delete($objInvite);
            }

            event(new UpdateTeam($objProject));

            return ($this->apiReply(null, "Deleted member", 204));
        }

        return ($this->apiReject(null, "Users not found.", 400));
    }

    /**
     * @param $project
     * @param DeleteMembers $deleteMembersRequest
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function deleteMembers($project, DeleteMembers $deleteMembersRequest) {
        $strProjectGroup = sprintf("App.Soundblock.Project.%s", $project);

        if (!is_authorized(AuthFacade::user(), $strProjectGroup, "App.Soundblock.Project.Member.Delete", "soundblock")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objGroup = $this->authGroupService->findByName($strProjectGroup);
        $objUser = $this->userService->findAllWhere($deleteMembersRequest->input("users"));
        $objProject = $this->projectService->find($project);
        $this->teamService->delete($objProject, $objUser, $objGroup);

        event(new UpdateTeam($objProject));

        return ($this->apiReply(null, "Deleted members", 204));
    }
}
