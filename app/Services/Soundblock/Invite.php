<?php

namespace App\Services\Soundblock;

use Util;
use Client;
use Constant;
use App\Events\Soundblock\UpdateTeam;
use App\Events\Soundblock\ProjectGroup;
use App\Contracts\Soundblock\Invite\Invite as InviteContract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repositories\Soundblock\{Invite as InviteRepository, Team as TeamRepository, Data\ProjectsRoles as ProjectsRolesRepository};
use App\Services\{Common\Common,
    Core\Auth\AuthGroup,
    Core\Auth\AuthPermission as AuthPermissionService,
    Email,
    User as UserService};
use App\Models\{
    Soundblock\Projects\Contracts\Contract,
    Soundblock\Invites,
    Soundblock\Projects\Project as ProjectModel,
    Soundblock\Projects\Team,
    Users\User};

class Invite implements InviteContract {
    /** @var InviteRepository */
    private InviteRepository $inviteRepository;
    /** @var UserService */
    private UserService $userService;
    /** @var TeamRepository */
    private TeamRepository $teamRepository;
    /** @var Email */
    private Email $emailService;
    /** @var AuthPermissionService */
    private AuthPermissionService $authPermissionService;
    /** @var AuthGroup */
    private AuthGroup $authGroupService;
    /** @var Common */
    private Common $commonService;
    /** @var ProjectsRolesRepository */
    private ProjectsRolesRepository $ProjectsRolesRepositoryRepo;

    /**
     * InviteService constructor.
     * @param InviteRepository $inviteRepository
     * @param TeamRepository $teamRepository
     * @param UserService $userService
     * @param Email $emailService
     * @param AuthPermissionService $authPermissionService
     * @param AuthGroup $authGroupService
     * @param Common $commonService
     * @param ProjectsRolesRepository $ProjectsRolesRepositoryRepo
     */
    public function __construct(InviteRepository $inviteRepository, TeamRepository $teamRepository, UserService $userService,
                                Email $emailService, AuthPermissionService $authPermissionService, AuthGroup $authGroupService,
                                Common $commonService, ProjectsRolesRepository $ProjectsRolesRepositoryRepo) {
        $this->userService           = $userService;
        $this->emailService          = $emailService;
        $this->commonService         = $commonService;
        $this->teamRepository        = $teamRepository;
        $this->inviteRepository      = $inviteRepository;
        $this->authGroupService      = $authGroupService;
        $this->authPermissionService = $authPermissionService;
        $this->ProjectsRolesRepositoryRepo = $ProjectsRolesRepositoryRepo;
    }

    /**
     * @param string $hash
     * @return Invites|null
     */
    public function getInviteByHash(string $hash): ?Invites {
        $objInvite = $this->inviteRepository->getInviteByHash($hash);

        if (is_null($objInvite)) {
            throw new NotFoundHttpException("Invalid Invite Hash");
        }

        return ($objInvite);
    }

    /**
     * @param string $email
     * @return Invites|null
     */
    public function getInviteByEmail(string $email): ?Invites {
        return ($this->inviteRepository->getInviteByEmail($email));
    }

    /**
     * @param Invites $invite
     * @param array $userData
     * @return User|null
     * @throws \Exception
     */
    public function useInvite(Invites $invite, array $userData): User {
        $objInvitable = $invite->invitable;

        if (is_null($objInvitable)) {
            throw new NotFoundHttpException("Invite Provider Not Found.");
        }

        $objUser = $this->userService->create($userData);
        $objInviteEmail = $this->emailService->create($invite->invite_email, $objUser, true);
        $this->emailService->verifyEmail($objInviteEmail);

        if ($invite->invite_email !== $userData["email"]) {
            $objNewEmail = $this->emailService->create($userData["email"], $objUser, true);
            $this->emailService->sendVerificationEmail($objNewEmail);
        }

        if ($objInvitable instanceof Contract) {
            $objUser = $this->attachUserToContract($invite, $objUser, $objInvitable);
        } else if ($objInvitable instanceof Team) {
            $objUser = $this->attachUserToTeam($invite, $objUser, $objInvitable);
        } else {
            throw new \Exception("Invalid Invite Provider.");
        }

        /** @var ProjectModel $objProject */
        $objProject = $objInvitable->project;
        $objAccount = $objProject->account;

        $objUser->accounts()->attach($objAccount->account_id, [
            "row_uuid" => Util::uuid(),
            "account_uuid" => $objProject->account_uuid,
            "user_uuid"    => $objUser->user_uuid,
        ]);

        event(new ProjectGroup($objUser, $objProject));

        $objServiceAuthGroup = $this->authGroupService->findByAccount($objProject->account);
        $this->authGroupService->addUserToGroup($objUser, $objServiceAuthGroup, Client::app());

        if (is_array($invite->invite_permissions)) {
            $this->authPermissionService->updateProjectGroupPermissions($invite->invite_permissions, $objUser, $objProject);
            $objInviteCollection = collect($invite->invite_permissions);
            $arrInvitePermission = $objInviteCollection->pluck("permission_name");
            $arrAccountPermission = Constant::account_level_permissions()->whereNotIn("permission_name", $arrInvitePermission);
            $arrAccountPermissionDisabled = Constant::account_level_permissions()->whereIn("permission_name", $arrInvitePermission);
            $this->authPermissionService->attachUserPermissions($arrAccountPermission, $objUser, $objServiceAuthGroup, false);
            $this->authPermissionService->attachUserPermissions($arrAccountPermissionDisabled, $objUser, $objServiceAuthGroup);
        }

        $this->commonService->acceptInvite($objProject->account, $objUser);

        event(new UpdateTeam($objProject));

        return ($objUser);
    }

    /**
     * @param Invites $invite
     * @param array $userData
     * @return User
     * @throws \Exception
     */
    public function inviteSignIn(Invites $invite, array $userData): User {
        $objInvitable = $invite->invitable;

        if (is_null($objInvitable)) {
            throw new NotFoundHttpException("Contract Not Found");
        }

        /** @var User $objUser */
        $objUser = $this->userService->findByEmailOrAlias($userData["user"]);

        if (is_null($objUser)) {
            throw new NotFoundHttpException("User Not Found.");
        }

        $objEmail = $this->emailService->findForUserByEmail($objUser, $invite->invite_email);

        if (is_null($objEmail)) {
            $this->emailService->create($invite->invite_email, $objUser, true);
        }

        if ($objInvitable instanceof Contract) {
            $objUser = $this->attachUserToContract($invite, $objUser, $objInvitable);
        } else if ($objInvitable instanceof Team) {
            $objUser = $this->attachUserToTeam($invite, $objUser, $objInvitable);
        } else {
            throw new \Exception("Invalid Invite Provider.");
        }

        $objProject = $objInvitable->project;

        event(new ProjectGroup($objUser, $objProject));

        if (is_array($invite->invite_permissions)) {
            $this->authPermissionService->updateProjectGroupPermissions($invite->invite_permissions, $objUser, $objProject);
        }

        $this->commonService->acceptInvite($objProject->account, $objUser);

        return $objUser;
    }

    /**
     * @param $objInvite
     * @param array $arrPermissions
     * @return mixed
     */
    public function updateInvitePermissions($objInvite, array $arrPermissions){
        $objInvite->update(["invite_permissions" => $arrPermissions["permissions"]]);

        return ($objInvite);
    }

    public function updateInviteRole(Invites $objInvite, string $role){
        $objRole = $this->ProjectsRolesRepositoryRepo->findProjectRole($role);

        return ($this->inviteRepository->updateInviteRole($objInvite, $objRole));
    }

    public function delete(Invites $objInvite) {
        $objInvite->delete();

        return $objInvite;
    }

    /**
     * @param Invites $invite
     * @param User $objUser
     * @param Contract $objContact
     * @return User
     * @throws \Exception
     */
    private function attachUserToContract(Invites $invite, User $objUser, Contract $objContact): User {
        $invite->contracts()->updateExistingPivot($invite->model_id, [
            "user_id"         => $objUser->user_id,
            "user_uuid"       => $objUser->user_uuid,
            "invite_id"       => null,
            "invite_uuid"     => null,
            "contract_status" => "Pending",
        ]);

        $objProject = $objContact->project;
        /** @var Team $objTeam */
        $objTeam = $objProject->team;

        if (is_null($objTeam)) {
            $objTeam = $this->teamRepository->create([
                "project_id"   => $objProject->project_id,
                "project_uuid" => $objProject->project_uuid,
            ]);
        }

        $objRole = $this->ProjectsRolesRepositoryRepo->find($invite->project_role_id);

        $this->teamRepository->addMember($objTeam, $objUser, [
            "user_payout" => $objContact->invite_payout,
        ], $objRole);

        $invite->flag_used = true;
        $invite->save();

        return $objUser;
    }

    /**
     * @param Invites $invite
     * @param User $objUser
     * @param Team $objTeam
     * @return User
     * @throws \Exception
     */
    private function attachUserToTeam(Invites $invite, User $objUser, Team $objTeam): User {
        $objRole = $this->ProjectsRolesRepositoryRepo->find($invite->project_role_id);

        $this->teamRepository->addMember($objTeam, $objUser, [
            "user_payout"  => $invite->invite_payout,
        ], $objRole);

        $invite->flag_used = true;
        $invite->save();

        return $objUser;
    }
}
