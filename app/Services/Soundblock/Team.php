<?php

namespace App\Services\Soundblock;

use Util;
use Client;
use Constant;
use App\Mail\Soundblock\Invite;
use Illuminate\Support\Facades\Mail;
use App\Events\Soundblock\InviteGroup;
use App\Events\Common\PrivateNotification;
use App\Mail\Soundblock\RemindInviteContract;
use App\Services\Common\AuthName as AuthService;
use App\Services\Core\Auth\AuthGroup as AuthGroupService;
use App\Models\{
    Users\User,
    Soundblock\Invites,
    Core\Auth\AuthGroup,
    Soundblock\Projects\Project,
    Soundblock\Projects\Team as TeamModel,
    Soundblock\Projects\Contracts\Contract,
};
use App\Repositories\{Soundblock\Data\ProjectsRoles,
    User\UserContactEmail,
    User\User as UserRepository,
    Soundblock\Team as TeamRepository,
    Soundblock\Project as ProjectRepository,
    Soundblock\Contract as ContractRepository,
    Core\Auth\AuthGroup as AuthGroupRepository,
    Core\Auth\AuthPermission as AuthPermissionRepository,
    Common\App as AppRepository
};

class Team {
    /** @var TeamRepository */
    protected TeamRepository $teamRepo;
    /** @var AuthGroupRepository */
    protected AuthGroupRepository $groupRepo;
    /** @var UserContactEmail */
    protected UserContactEmail $emailRepo;
    /** @var UserRepository */
    protected UserRepository $userRepo;
    /** @var ProjectRepository */
    protected ProjectRepository $projectRepo;
    /** @var AuthGroupService */
    private AuthGroupService $authGroupService;
    /** @var ContractRepository */
    private ContractRepository $contractRepository;
    /** @var AppRepository */
    private AppRepository $appRepo;
    /** @var AuthService */
    private AuthService $authService;
    /** @var AuthPermissionRepository */
    private AuthPermissionRepository $authPermissionRepo;
    /** @var \App\Repositories\Soundblock\Data\ProjectsRoles */
    private ProjectsRoles $projectsRolesRepository;

    /**
     * TeamService constructor.
     * @param TeamRepository $teamRepo
     * @param AuthGroupRepository $groupRepo
     * @param UserContactEmail $emailRepo
     * @param UserRepository $userRepo
     * @param ProjectRepository $projectRepo
     * @param AuthGroupService $authGroupService
     * @param ContractRepository $contractRepository
     * @param AppRepository $appRepo
     * @param AuthService $authService
     * @param AuthPermissionRepository $authPermissionRepo
     * @param \App\Repositories\Soundblock\Data\ProjectsRoles $projectsRolesRepository
     */
    public function __construct(TeamRepository $teamRepo, AuthGroupRepository $groupRepo, UserContactEmail $emailRepo,
                                UserRepository $userRepo, ProjectRepository $projectRepo, AuthGroupService $authGroupService,
                                ContractRepository $contractRepository, AppRepository $appRepo, AuthService $authService,
                                AuthPermissionRepository $authPermissionRepo, ProjectsRoles $projectsRolesRepository) {
        $this->appRepo = $appRepo;
        $this->userRepo = $userRepo;
        $this->teamRepo = $teamRepo;
        $this->groupRepo = $groupRepo;
        $this->emailRepo = $emailRepo;
        $this->projectRepo = $projectRepo;
        $this->authService = $authService;
        $this->authGroupService = $authGroupService;
        $this->contractRepository = $contractRepository;
        $this->authPermissionRepo = $authPermissionRepo;
        $this->projectsRolesRepository = $projectsRolesRepository;
    }

    /**
     * @param $id
     * @param bool|null $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find($id, ?bool $bnFailure = true) {
        return ($this->teamRepo->find($id, $bnFailure));
    }

    /**
     * @param string $project
     * @return TeamModel
     * @throws \Exception
     */
    public function findByProject(string $project): TeamModel {
        $objProject = $this->projectRepo->find($project, true);

        return ($objProject->team);
    }

    /**
     * @param Project $objProject
     * @return TeamModel
     */
    public function getUsers(Project $objProject): TeamModel {
        $objHolder = $objProject->account->user;

        /** @var TeamModel */
        $objTeam = $objProject->team;
        $objContract = $objProject->contracts()->whereNull(Contract::STAMP_ENDS)->first();

        $objTeam->load(["users" => function ($q) {
            $q->select("users.*", "soundblock_projects_teams_users.user_role");
        }, "invite"             => function ($query) {
            $query->where("flag_used", 0);
        }]);
        $objTeam->users->load(["contracts" => function ($q) use ($objContract, $objProject) {
            $q->select("soundblock_projects_contracts_users.contract_status", "soundblock_projects_contracts_users.user_payout",
                "soundblock_projects_contracts.stamp_begins", "soundblock_projects_contracts.stamp_ends");
            $q->where("soundblock_projects_contracts.project_id", $objProject->project_id);
            $q->where("soundblock_projects_contracts.project_id", $objProject->project_id);
            if (isset($objContract)) {
                $q->wherePivot("contract_id", $objContract->contract_id)
                    ->wherePivot("contract_version", $objContract->contract_version);
            }
        }]);

        $users = $objTeam->users->map(function ($user) use ($objHolder, $objTeam) {
            $flagRemind = false;
            $flagRemindIn = 0;
            $objRole = [];

            if (isset($user->pivot->role_uuid)) {
                $objRole = $this->projectsRolesRepository->findProjectRole($user->pivot->role_uuid);
            }

            if ((time() - $user->pivot->stamp_remind) > 86400) {
                $flagRemind = true;
            } else {
                $flagRemindIn = 86400 - (time() - $user->pivot->stamp_remind);
            }

            $objAccount = $objTeam->project->account;
            $userService = $objAccount->users()->where("users.user_uuid", $user->user_uuid)->first();

            $item = [
                "user_uuid"               => $user->user_uuid,
                "name"                    => $user->name,
                "user_role"               => $user->user_role,
                "role"                    => $objRole,
                "user_auth_email"         => is_null($user->primary_email) ? null : $user->primary_email->user_auth_email,
                "user_payout"             => null,
                "contract_status"         => null,
                "is_owner"                => $objHolder->user_uuid == $user->user_uuid,
                "flag_remind"             => $flagRemind,
                "flag_remind_in"          => $flagRemindIn,
                "flag_exists_in_contract" => $user["contracts"]->isNotEmpty(),
                "flag_accepted"           => $userService ? boolval($userService->pivot->flag_accepted) : null,
            ];
            $objContract = null;
            if (count($user["contracts"]) > 0) {
                $objContract = $user["contracts"][0];
                $item = array_merge($item, [
                    "user_payout"     => $objContract->user_payout,
                    "contract_status" => $objContract->contract_status,
                ]);
            }
            return ($item);
        });
        unset($objTeam->users);
        $users = $users->sortBy("name")->values();
        $objTeam->invite->sortBy("invite_name")->values();
        $objTeam->invite->each(function ($invite) {
            $flagRemind = false;
            $flagRemindIn = 0;

            if ((time() - $invite->stamp_remind) > 86400) {
                $flagRemind = true;
            } else {
                $flagRemindIn = 86400 - (time() - $invite->stamp_remind);
            }

            $invite->flag_remind = $flagRemind;
            $objRole = $this->projectsRolesRepository->find($invite->project_role_uuid);
            $invite->invite_role = $objRole->data_role;
            $invite->flag_remind_in = $flagRemindIn;
        });

        $objTeam->users = $users->each(function ($value, $key) use ($users) {
            if ($value["is_owner"]) {
                $users->forget($key);
                $users->prepend($value);

                return false;
            }
        });

        return ($objTeam);
    }

    public function getInvite(Project $objProject, string $invite) {
        /** @var TeamModel $objTeam */
        $objTeam = $objProject->team;

        if (is_null($objTeam)) {
            throw new \Exception("Project Doesn't Have Team.", 400);
        }

        return $objTeam->invite()->where("invite_uuid", $invite)->first();
    }

    /**
     * @param $objTeam
     * @param string $permission
     * @return mixed
     */
    public function findUsersWhereAccountPermission($objTeam, string $permission) {
        $objGroup = $this->groupRepo->findByAccount($objTeam->project->account);
        $objPermission = $this->authPermissionRepo->findByName($permission);

        $objUsers = $objPermission->pusers()->where("core_auth_permissions_groups_users.permission_value", true)
            ->where("core_auth_permissions_groups_users.group_uuid", $objGroup->group_uuid)
            ->get();

        $objUsersWithPermission = $objTeam->users()->whereIn("users.user_uuid", $objUsers->pluck("user_uuid"))->get();
        $objUsersWithPermission->map(function ($user) {
            if ($user->pivot->user_role == "Owner") {
                $user->is_owner = true;
            } else {
                $user->is_owner = false;
            }
        });

        return ($objUsersWithPermission);
    }

    /**
     * @param Project $project
     * @return TeamModel
     */
    public function create(Project $project): TeamModel {
        /** @var array */
        $arrTeam = $project->only("project_id", "project_uuid");

        return ($this->teamRepo->create($arrTeam));
    }

    /**
     * @param array $arrParams
     * @return User|Invites
     * @throws \Exception
     */
    public function storeMember(array $arrParams) {
        $objUser = null;
        $objEmail = null;

        if (isset($arrParams["user_uuid"])) {
            /** @var User $objUser */
            $objUser = $this->userRepo->find($arrParams["user_uuid"], true);
            $objEmail = $objUser->primary_email;

        } else if (isset($arrParams["user_auth_email"])) {
            $objEmail = $this->emailRepo->find($arrParams["user_auth_email"], false);

            if (isset($objEmail)) {
                $objUser = $objEmail->user;
            }
        } else {
            throw new \Exception("Invalid Request.", 400);
        }

        /** @var TeamModel $objTeam */
        if (is_object($arrParams["team"])) {
            $objTeam = $arrParams["team"];
        } else if (is_string($arrParams["team"])) {
            $objTeam = $this->find($arrParams["team"]);
        } else {
            throw new \Exception("Invalid Team Type");
        }

        $objProject = $objTeam->project;

        if (is_null($objUser)) {
            $bnIsAlreadyInvited = $objTeam->invite()->where("invite_email", $arrParams["user_auth_email"])
                                          ->exists();

            if ($bnIsAlreadyInvited) {
                throw new \Exception("You Already Have Invited This User To Current Team.");
            }

            $arrData = [
                "invite_uuid"        => Util::uuid(),
                "invite_email"       => $arrParams["user_auth_email"],
                "invite_name"        => $arrParams["first_name"] . " " . $arrParams["last_name"],
                "invite_permissions" => $arrParams["permissions"] ?? null,
                "stamp_remind"       => time(),
            ];

            $objProjectRole = $this->projectsRolesRepository->findProjectRole($arrParams["user_role_id"]);

            if (is_null($objProjectRole)) {
                throw new \Exception("Invalid Project Role.");
            }

            $arrData["project_role_id"] = $objProjectRole->data_id;
            $arrData["project_role_uuid"] = $objProjectRole->data_uuid;
            $strRole = $objProjectRole->data_role;

            /** @var Invites $objInvite */
            $objInvite = $objTeam->invite()->create($arrData);

            $params = [
                "Role" => $strRole,
            ];
            Mail::to($arrParams["user_auth_email"])
                ->send(new Invite($objProject, Client::app(), $objInvite, $params, true));

            return $objInvite;
        } else {
            $flagAccept = true;
            $objProjectRole = null;

            $objApp = $this->appRepo->findOneByName("soundblock");
            $objAuth = Util::makeAuth($objApp);
            $objProjectGroup = $this->authGroupService->findByName(Util::makeGroupName($objAuth, "project", $objProject));

            $checkUserInGroup = $this->authGroupService->checkIfUserExists($objUser, $objProjectGroup);

            if ($checkUserInGroup === Constant::EXIST) {
                throw new \Exception("This User Is Already Part Of Current Team.");
            }

            $userService = $objUser->accounts()->where("soundblock_accounts.account_id", $objProject->account_id)
                                   ->first();

            if (is_null($userService)) {
                $objUser->accounts()->attach($objProject->account_id, [
                    "row_uuid"     => Util::uuid(),
                    "account_uuid" => $objProject->account_uuid,
                    "user_uuid"    => $objUser->user_uuid,
                ]);
            } else {
                $flagAccept = false;
                if (!is_null($userService->pivot->stamp_deleted)) {
                    $objUser->accounts()->updateExistingPivot($objProject->account_id, [
                        "flag_accepted"    => false,
                        "stamp_deleted"    => null,
                        "stamp_deleted_at" => null,
                        "stamp_deleted_by" => null,
                    ]);
                }
            }

            $objProjectRole = $this->projectsRolesRepository->findProjectRole($arrParams["user_role_id"]);

            if (is_null($objProjectRole)) {
                throw new \Exception("Invalid Project Role.");
            }

            $strRole = $objProjectRole->data_role;

            $this->teamRepo->addMember($objTeam, $objUser, $arrParams, $objProjectRole);

            event(new InviteGroup($objEmail, $objProject, $this->authService->findOneByName("App.Soundblock"), $objApp));

            $params = ["Role" => $strRole];

            Mail::to($objUser->primary_email->user_auth_email)
                ->send(new Invite($objProject, Client::app(), null, $params, $flagAccept));

            $data = [
                "notification_name" => "Hello",
                "notification_memo" => "You are invited to project {$objProject->project_title}.",
                "autoClose"         => true,
                "showTime"          => 5000,
            ];
            $flags = [
                "notification_state" => "unread",
                "flag_canarchive"    => true,
                "flag_candelete"     => true,
                "flag_email"         => false,
            ];

            event(new PrivateNotification($objUser, $data, $flags, Client::app()));
        }


        return ($objEmail->user);
    }

    /**
     * @param TeamModel $objTeam
     * @param \Illuminate\Support\Collection $arrInfo
     * @return TeamModel
     */
    public function addMembers(TeamModel $objTeam, $arrInfo): TeamModel {
        return ($this->teamRepo->addMembers($objTeam, $arrInfo));
    }

    /**
     * @param TeamModel $objTeam
     * @param array $arrParams
     * @return mixed
     */
    public function update(TeamModel $objTeam, array $arrParams) {
        foreach ($arrParams as $member) {
            $objTeam->users()->where("soundblock_projects_teams_users.user_uuid", $member["uuid"])->update([
                "soundblock_projects_teams_users.user_role" => $member["role"],
            ]);
        }

        return ($objTeam->users);
    }

    /**
     * @param Project $objProject
     * @param array $arrParams
     * @return bool
     * @throws \Exception
     */
    public function remind(Project $objProject, array $arrParams) {
        $objTeam = $objProject->team;
        $boolResult = false;

        if (isset($arrParams["user_uuid"])) {
            $boolResult = $this->sendUserRemind($objTeam, $arrParams["user_uuid"]);
        } else if (isset($arrParams["invite_uuid"])) {
            $boolResult = $this->sendInviteRemind($objTeam, $arrParams["invite_uuid"]);
        }

        return ($boolResult);
    }

    /**
     * @param Project $objProject
     * @param \Illuminate\Database\Eloquent\Collection $arrUser
     * @param AuthGroup $objAuthGroup
     * @return AuthGroup
     */
    public function delete(Project $objProject, $arrUser, AuthGroup $objAuthGroup): AuthGroup {
        $objCheckedUsers = collect();
        /** @var TeamModel $objTeam */
        $objTeam = $objProject->team;

        /** @var User $objUser */
        foreach ($arrUser as $objUser) {
            $checked = $this->contractRepository->checkUserInProjectContracts($objUser, $objProject);
            if ($checked === false) {
                $objCheckedUsers->add($objUser);
                $objTeam->users()->detach($objUser->user_id);
            }
        }

        return ($this->authGroupService->detachUsersFromGroup($objCheckedUsers, $objAuthGroup));
    }

    private function sendUserRemind($objTeam, string $user_uuid) {
        $email = null;
        $params = null;

        $objUser = $objTeam->users()->whereHas("accounts", function ($query) {
            $query->where("soundblock_accounts_users.flag_accepted", false);
        })->where("soundblock_projects_teams_users.user_uuid", $user_uuid)->first();

        if (empty($objUser)) {
            throw new \Exception("Member not found or already accepted invite.", 400);
        }

        if (!empty($objUser->emails)) {
            $email = $objUser->primary_email->user_auth_email;
        } else {
            throw new \Exception("User don't have email.", 400);
        }

        $timeFromDb = $objUser->pivot->stamp_remind;
        $dif = time() - $timeFromDb;

        if ($dif > 86400) {
            $params = [
                "Role" => $objUser->pivot->user_role,
            ];
            Mail::to($email)->send(new RemindInviteContract($objTeam->project, Client::app(), $params));
            $objTeam->users()->where("soundblock_projects_teams_users.user_uuid", $user_uuid)
                               ->update(["soundblock_projects_teams_users.stamp_remind" => time()]);

            $data = [
                "notification_name" => "Hello",
                "notification_memo" => "We remind you that you were invited to the account {$objTeam->project->account->account_name}.",
                "autoClose"         => true,
                "showTime"          => 5000,
            ];
            $flags = [
                "notification_state" => "unread",
                "flag_canarchive"    => true,
                "flag_candelete"     => true,
                "flag_email"         => false,
            ];

            event(new PrivateNotification($objUser, $data, $flags, Client::app()));
        } else {
            throw new \Exception("You Can Send Reminders One Time Per 24 Hours.", 400);
        }

        return (true);
    }

    private function sendInviteRemind($objTeam, string $invite_uuid) {
        $params = null;
        $objInvite = $objTeam->invite()->where("invite_uuid", $invite_uuid)->where("flag_used", 0)->first();

        if (empty($objInvite)) {
            throw new \Exception("Invite user not found or already accepted invite.", 400);
        }

        $email = $objInvite->invite_email;
        $timeFromDb = $objInvite->stamp_remind;
        $dif = time() - $timeFromDb;

        if ($dif > 86400) {
            $params = [
                "Role" => $objInvite->invite_role,
            ];
            Mail::to($email)->send(new RemindInviteContract($objTeam->project, Client::app(), $params));
            $objInvite->update(["stamp_remind" => time()]);
        } else {
            throw new \Exception("You Can Send Reminders One Time Per 24 Hours.", 400);
        }

        return (true);
    }
}
