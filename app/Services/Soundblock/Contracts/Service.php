<?php

namespace App\Services\Soundblock\Contracts;

use Mail;
use Auth;
use Builder;
use Util;
use Client;
use App\Events\Soundblock\ProjectGroup;
use App\Events\Common\PrivateNotification;
use App\Events\Soundblock\ContractChanges;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Soundblock\Contracts\SmartContracts;
use App\Jobs\Soundblock\Ledger\ContractLedger as ContractLedgerJob;
use App\Services\Soundblock\Ledger\ContractLedger as ContractLedgerService;
use App\Mail\Soundblock\{
    Contract\Accepted,
    Contract\Rejected,
    Contract\Activated,
    Contract\Created,
    Contract\Modifying,
    Contract\Voided,
    RemindInviteContract,
    ConfirmInvite,
    Invite
};
use App\Models\{
    Users\User,
    Soundblock\Invites,
    Soundblock\Projects\Team,
    Soundblock\Projects\Project,
    Soundblock\Projects\Contracts\Contract,
    Soundblock\Accounts\Account as AccountModel,
};
use App\Repositories\{
    User\User as UserRepository,
    Soundblock\Team as TeamRepository,
    Soundblock\Project as ProjectRepository,
    Soundblock\Contract as ContractRepository,
    Soundblock\Data\ProjectsRoles as ProjectRolesRepository
};

class Service implements SmartContracts {
    /** @var ContractRepository */
    private ContractRepository $contractRepo;
    /** @var ProjectRepository */
    private ProjectRepository $projectRepo;
    /** @var UserRepository */
    private UserRepository $userRepo;
    /** @var TeamRepository */
    private TeamRepository $teamRepo;
    /** @var ProjectRolesRepository */
    private ProjectRolesRepository $projectsRolesRepo;

    /**
     * ContractService constructor.
     * @param ContractRepository $contractRepo
     * @param ProjectRepository $projectRepo
     * @param UserRepository $userRepo
     * @param TeamRepository $teamRepo
     * @param ProjectRolesRepository $projectsRolesRepo
     */
    public function __construct(ContractRepository $contractRepo, ProjectRepository $projectRepo, UserRepository $userRepo,
                                TeamRepository $teamRepo, ProjectRolesRepository $projectsRolesRepo) {
        $this->contractRepo = $contractRepo;
        $this->projectRepo = $projectRepo;
        $this->userRepo = $userRepo;
        $this->teamRepo = $teamRepo;
        $this->projectsRolesRepo = $projectsRolesRepo;
    }

    /**
     * Find latest record in database
     *
     * @param Project $project
     * @param bool $blFail
     * @return Contract|null
     */
    public function findLatest(Project $project, bool $blFail = true): ?Contract {
        return $this->contractRepo->findLatestByProject($project, $blFail);
    }

    /**
     * Find Contract by ID|UUID
     *
     * @param $id
     * @param bool $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find(string $id, bool $bnFailure = true): ?Contract {
        return ($this->contractRepo->find($id, $bnFailure));
    }

    /**
     * Find First Contract by project UUID
     *
     * @param $project
     * @return mixed
     * @throws \Exception
     */
    public function findByProject($project) {
        $objProject = $this->projectRepo->find($project, true);

        return ($objProject->contract);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $arrProjects
     * @param array $arrStatus
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatestByProjectsAndStatus($arrProjects, array $arrStatus): \Illuminate\Database\Eloquent\Collection {
        $arrContracts = new Collection();

        foreach ($arrProjects as $objProject) {
            /**
             * @var Contract|null
             */
            $objContract = $this->contractRepo->findByUserAndStatus(Auth::user(), $objProject, $arrStatus);

            if ($objContract) {
                $arrContracts->push($objContract);
            }
        }

        return ($arrContracts);
    }

    /**
     * This is the function for ContractController@get
     * @param Contract $objContract
     * @return Contract
     */
    public function getContractInfo(Contract $objContract): Contract {
        $objContract = $objContract->load(["users" => function ($query) use ($objContract) {
            $query->select(["users.*", "soundblock_projects_contracts_users.user_payout",
                            "soundblock_projects_contracts_users.contract_status", "soundblock_projects_contracts_users.flag_action"]);
            $query->where("soundblock_projects_contracts_users.contract_version", $objContract->contract_version);

            if (strtolower($objContract->flag_status) === "active") {
                $query->where("soundblock_projects_contracts_users.flag_action", "!=", "delete");
            }
        }, "users.teams"                           => function ($query) use ($objContract) {
            $query->select(["soundblock_projects_teams_users.role_uuid"]);
            $query->where("soundblock_projects_teams.project_id", $objContract->project->project_id);
        }, "contractInvites"                       => function ($query) use ($objContract) {
            $query->select([
                "soundblock_invites.invite_email",
                "soundblock_invites.invite_name",
                "soundblock_invites.invite_role",
                "soundblock_invites.invite_payout",
                "soundblock_projects_contracts_users.stamp_remind",
                "soundblock_invites.invite_uuid",
            ]);
            $query->where("soundblock_projects_contracts_users.contract_version", $objContract->contract_version);
        }])->makeHidden("project", "team");

        $objServiceHolder = $objContract->project->account->user;

        $users = $objContract->users->map(function ($item) use ($objServiceHolder) {
            $flagRemind = false;
            $timeFromDb = $item->pivot->stamp_remind;
            $dif = time() - $timeFromDb;

            if ($dif > 86400) {
                $flagRemind = true;
            }

            if ($item->teams->isNotEmpty()) {
                $strUserRole = $this->projectsRolesRepo->find($item->teams[0]->role_uuid)->data_role;
            } else {
                $strUserRole = null;
            }

            return [
                "user_uuid"       => $item->user_uuid,
                "user_auth_email" => is_null($item->primary_email) ? null : $item->primary_email->user_auth_email,
                "user_payout"     => $item->user_payout,
                "contract_status" => $item->contract_status,
                "name"            => $item->name,
                "user_role"       => $strUserRole,
                "flag_action"     => $item->flag_action,
                "flag_remind"     => $flagRemind,
                "is_owner"        => $item->user_id === $objServiceHolder->user_id,
            ];
        });

        $objContract["contract_users"] = $users;
        $objContract = $objContract->makeHidden("users");

        if (strtolower($objContract->flag_status) === "modifying") {
            $objActiveHistory = $this->contractRepo->getActiveHistory($objContract);

            if (isset($objActiveHistory)) {
                $arrPrevious = $objActiveHistory->contract_state;
                unset($arrPrevious["project"], $arrPrevious["project_id"], $arrPrevious["account_id"], $arrPrevious["contract_id"]);
                $objPrevUsers = $this->contractRepo->getUsersByCycle($objContract, $arrPrevious["contract_version"]);

                $arrPrevious["users"] = $objPrevUsers->map(function ($item) {
                    if ($item->teams->isNotEmpty() && optional($item->teams[0]->pivot)->role_uuid) {
                        $strUserRole = $this->projectsRolesRepo->find($item->teams[0]->pivot->role_uuid)->data_role;
                    } else {
                        $strUserRole = null;
                    }

                    return [
                        "user_uuid"       => $item->user_uuid,
                        "user_auth_email" => is_null($item->primary_email) ? null : $item->primary_email->user_auth_email,
                        "user_payout"     => $item->pivot->user_payout,
                        "contract_status" => $item->pivot->contract_status,
                        "name"            => $item->name,
                        "user_role"       => $strUserRole,
                    ];
                });

                $objContract["previous"] = $arrPrevious;
            }
        }

        if (!empty($objContract["contractInvites"])) {
            foreach ($objContract["contractInvites"] as $key => $invite) {
                $timeFromDb = $invite->stamp_remind;
                unset($objContract["contractInvites"][$key]["stamp_remind"]);
                $objContract["contractInvites"][$key]["flag_remind"] = false;

                if ((time() - $timeFromDb) > 86400) {
                    $objContract["contractInvites"][$key]["flag_remind"] = true;
                }
            }
        }

        return ($objContract);
    }

    public function getContractMembersByCycle(Contract $objContract, ?int $version = null) {
        return $this->contractRepo->getUsersByCycle($objContract, $version);
    }

    public function getContractUserInfo(Contract $objContract, User $objUser) {
        return $this->contractRepo->getContractUserDetails($objContract, $objUser);
    }

    /**
     * Check that user have access to contract
     *
     * @param Contract $objContract
     * @param User $objUser
     * @return bool
     */
    public function checkAccess(Contract $objContract, User $objUser): bool {
        return $this->contractRepo->checkUserExist($objContract, $objUser);
    }

    /**
     * @param Contract $contract
     *
     * @return bool
     */
    public function canModify(Contract $contract): bool {
        return ($this->contractRepo->canModify($contract));
    }

    public function checkActiveContract(Project $objProject) {
        $objContract = $this->findLatest($objProject, false);

        if (is_null($objContract)) {
            return false;
        }

        return strtolower($objContract->flag_status) == "active";
    }

    /**
     * Create new contract and set status as Pending
     *
     * @param Project $objProject
     * @param AccountModel $account
     * @param array $arrParams
     * @return mixed
     * @throws \Exception
     */
    public function create(Project $objProject, AccountModel $account, array $arrParams): Contract {
        try {
            \DB::beginTransaction();

            /** @var User $objAuthUser */
            $objAuthUser = \Auth::user();
            /** @var Contract $objContract */
            $objContract = $objProject->contracts()->create([
                "contract_uuid"    => Util::uuid(),
                "project_uuid"     => $objProject->project_uuid,
                "account_id"       => $account->account_id,
                "account_uuid"     => $account->account_uuid,
                "flag_status"      => "Pending",
                "contract_version" => 1,
            ]);

            dispatch(new ContractLedgerJob($objContract, ContractLedgerService::NEW_CONTRACT_EVENT))->onQueue("ledger");

            $this->contractRepo->createContractHistory($objContract, $objAuthUser, "create");

            if (is_array($arrParams["members"])) {
                $objContract = $this->saveMembers($objContract, $objProject, $arrParams["members"]);
            }

            $this->contractRepo->createContractUsersHistory($objContract, $objAuthUser, "create");

            $arrUsers = $this->contractRepo->getUsersByCycle($objContract)->where("user_id", "!=", $objAuthUser->user_id)->all();

            $notificationAction = Builder::notification_link([
                    "link_name" => "Accept",
                    "url"       => app_url("soundblock") . "project/contract/" . $objContract->contract_uuid . "/accept",
                ]) . Builder::notification_link([
                    "link_name" => "Reject",
                    "url"       => app_url("soundblock") . "project/contract/" . $objContract->contract_uuid . "/reject",
                ]);
            $startContract = [
                "notification_name"   => "Hello",
                "notification_memo"   => "{$objAuthUser->name} created \"{$objProject->project_title}\" project's contract.",
                "notification_action" => $notificationAction,
            ];

            $this->notify($startContract, $arrUsers);

            event(new ContractChanges($objContract));

            $arrContractUsers = $objContract->users()->wherePivot("contract_version", $objContract->contract_version)->get();
            foreach ($arrContractUsers as $objUser) {
                Mail::to($objUser->primary_email->user_auth_email)->send(new Created($objContract, Client::app()));
            }

            foreach ($arrParams["members"] as $member) {
                if (isset($member["uuid"])) {
                    $objUser = $this->userRepo->find($member["uuid"]);
                    if ($objUser->user_id == $objAuthUser->user_id) {
                        $this->acceptContract($objContract, $objUser);
                    }
                }
            }

            \DB::commit();

            return $objContract;
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

    }

    /**
     * @param Contract $objContract
     * @param array $arrParams
     * @return Contract
     * @throws \Exception
     */
    public function update(Contract $objContract, array $arrParams): Contract {
        try {
            \DB::beginTransaction();

            /** @var User $objAuthUser */
            $objAuthUser = \Auth::user();
            $objProject = $objContract->project;
            $strPrevState = strtolower($objContract->flag_status);

            $objContract->flag_status = "Modifying";
            $objContract->contract_version = $this->contractRepo->getCurrentCycle($objContract) + 1 ?? 1;
            $objContract->save();

            $this->contractRepo->createContractHistory($objContract, $objAuthUser, "modifying");

            if (is_array($arrParams["members"])) {
                $objContract = $this->saveMembers($objContract, $objProject, $arrParams["members"]);
            }

            $strUpdateEvent = $strPrevState == "voided" ? ContractLedgerService::NEW_AFTER_VOIDED : ContractLedgerService::MODIFY_CONTRACT;

            dispatch(new ContractLedgerJob($objContract, $strUpdateEvent))->onQueue("ledger");

            $this->contractRepo->createContractUsersHistory($objContract, $objAuthUser, "modifying");

            $arrUsers = $this->contractRepo->getUsersByCycle($objContract)->where("user_id", "!=", $objAuthUser->user_id)
                                           ->all();

            $notificationAction = Builder::notification_link([
                    "link_name" => "Accept",
                    "url"       => app_url("soundblock") . "project/contract/" . $objContract->contract_uuid . "/accept",
                ]) . Builder::notification_link([
                    "link_name" => "Reject",
                    "url"       => app_url("soundblock") . "project/contract/" . $objContract->contract_uuid . "/reject",
                ]);

            $startContract = [
                "notification_name"   => "Hello",
                "notification_memo"   => "{$objAuthUser->name} modified \"{$objProject->project_title}\" project's contract.",
                "notification_action" => $notificationAction,
            ];

            foreach ($arrParams["members"] as $member) {
                if (isset($member["uuid"])) {
                    $objUser = $this->userRepo->find($member["uuid"]);
                    if ($objUser->user_id == $objAuthUser->user_id) {
                        $this->acceptContract($objContract, $objUser, false);
                    }
                }
            }

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            throw $exception;
        }

        $this->notify($startContract, $arrUsers);
        event(new ContractChanges($objContract));

        $arrContractUsers = $objContract->users()->wherePivot("contract_version", $objContract->contract_version)->get();
        foreach ($arrContractUsers as $objUser) {
            Mail::to($objUser->primary_email->user_auth_email)->send(new Modifying($objContract, Client::app(), $objAuthUser));
        }

        return $objContract;
    }

    /**
     * Attach Users to Contract
     *
     * @param Contract $objContract
     * @param Project $objProject
     * @param array $arrMembers
     * @return Contract
     * @throws \Exception
     */
    private function saveMembers(Contract $objContract, Project $objProject, array $arrMembers) {
        $removedUsers = [];
        $arrLastActiveUsers = collect();
        $teamUsersUuid = collect($arrMembers)->pluck("uuid")->toArray();
        $intCurrentCycle = $this->contractRepo->getCurrentCycle($objContract);
        $objLastActive = $this->contractRepo->getActiveHistory($objContract);

        if (isset($objLastActive)) {
            $removedUsers = $this->contractRepo->getDeletedUsers($objContract, $teamUsersUuid, $objLastActive->contract_state["contract_version"]);
        }

        if (is_object($objLastActive)) {
            $arrLastActiveUsers = $this->contractRepo->getUsersByCycle($objContract, $objLastActive->contract_state["contract_version"]);
        }

        foreach ($arrMembers as $member) {
            if (isset($member["uuid"])) {
                /** @var User $objUser */
                $objUser = $this->userRepo->find($member["uuid"]);
                $objAccount = $objUser->accounts()->find($objProject->account_id);
                $objOwnerService = $objUser->userAccounts()->find($objProject->account_id);

                if (is_null($objAccount) && is_null($objOwnerService)) {
                    throw new \Exception("Cannot Attach Not Account Member To Contract.");
                }

                $objContract->users()->attach($objUser->user_id, [
                    "row_uuid"         => Util::uuid(),
                    "contract_uuid"    => $objContract->contract_uuid,
                    "user_uuid"        => $objUser->user_uuid,
                    "contract_status"  => "Pending",
                    "user_payout"      => $member["payout"],
                    "contract_version" => $intCurrentCycle + 1,
                    "flag_action"      => $arrLastActiveUsers->where("user_uuid", $member["uuid"])
                                                             ->isEmpty() ? "add" : "modify",
                    "stamp_remind"     => time(),
                ]);

                /** @var Team $objTeam */
                $objTeam = $objProject->team;
                $objRole = $this->projectsRolesRepo->find($member["role_id"]);

                $this->teamRepo->addMember($objTeam, $objUser, [
                    "user_payout" => $member["payout"],
                ], $objRole);

                if ($objUser->user_id !== Auth::user()->user_id) {
                    $params = [
                        "Role"   => $objRole->data_role,
                        "Payout" => $member["payout"] . "%",
                    ];

                    Mail::to($objUser->primary_email->user_auth_email)->send(new Invite($objProject, Client::app(), null, $params, false, true));
                }
            } else {
                $objRole = $this->projectsRolesRepo->find($member["role_id"]);

                /** @var Invites $objInvite */
                $objInvite = $objContract->invites()->create([
                    "invite_uuid"   => Util::uuid(),
                    "invite_email"  => $member["email"],
                    "invite_name"   => $member["name"],
                    "invite_payout" => $member["payout"],
                    "project_role_id" => $objRole->data_id,
                    "project_role_uuid" => $objRole->data_uuid,
                ]);

                $objContract->contractInvites()->attach($objInvite->invite_id, [
                    "row_uuid"         => Util::uuid(),
                    "contract_uuid"    => $objContract->contract_uuid,
                    "contract_status"  => "Awaiting Registration",
                    "user_payout"      => $member["payout"],
                    "invite_uuid"      => $objInvite->invite_uuid,
                    "contract_version" => $intCurrentCycle + 1,
                    "stamp_remind"     => time(),
                ]);

                $params = [
                    "Role"   => Util::ucLabel($objRole->data_role),
                    "Payout" => $member["payout"] . "%",
                ];
                Mail::to($member["email"])->send(new Invite($objProject, Client::app(), $objInvite, $params, true, true));
            }
        }

        foreach ($removedUsers as $removedUser) {
            $objContract->users()->attach($removedUser->user_id, [
                "row_uuid"         => Util::uuid(),
                "contract_uuid"    => $objContract->contract_uuid,
                "user_uuid"        => $removedUser->user_uuid,
                "contract_status"  => "Pending",
                "user_payout"      => 0,
                "contract_version" => $intCurrentCycle + 1,
                "flag_action"      => "delete",
            ]);
        }

        return $objContract;
    }

    /**
     * Set status of user as accepted. if it was latest user who not accept set contract status as "Accepted"
     *
     * @param Contract $contract
     * @param User $user
     * @param bool $flagNotifyUser
     * @return Contract
     * @throws \Exception
     */
    public function acceptContract(Contract $contract, User $user, bool $flagNotifyUser = true): Contract {
        $objAccount = $user->accounts()->find($contract->project->account_id);

        if ($objAccount->pivot->flag_accepted == false) {
            $this->acceptServiceInvite($objAccount, $user);
        }

        $objUserDetails = $this->contractRepo->getContractUserDetails($contract, $user);
        $objProject = $contract->project;

        if ($objUserDetails->contract_status !== "Pending") {
            throw new \Exception("You are already " . strtolower($objUserDetails->contract_status) . " this contract", 400);
        }

        $this->contractRepo->updateContractUser($contract, $user, "Accepted");
        $this->contractRepo->createContractUsersHistory($contract, $user, "accept");
        $arrContractWithoutAcceptedUsers = $contract->users()->where("users.user_id", "!=", $user->user_id)->get()
                                                    ->unique("user_id")->all();

        dispatch(new ContractLedgerJob($contract, ContractLedgerService::USER_ACCEPT_ACTION, $user))->onQueue("ledger");

        $contents = [
            "notification_name" => "Hello",
            "notification_memo" => "{$user->name} accepted \"{$objProject->project_title}\" project's contract.",
            "autoClose"         => true,
            "showTime"          => 5000,
        ];

        event(new ProjectGroup($user, $contract->project));
        $this->notify($contents, $arrContractWithoutAcceptedUsers);

        if ($flagNotifyUser) {
            Mail::to($user->primary_email->user_auth_email)->send(new Accepted($contract, Client::app(), false));
        }

        if ($contract->account->user->user_id !== $user->user_id) {
            Mail::to($contract->account->user->primary_email->user_auth_email)->send(new Accepted($contract, Client::app(), true, $user->name));
        }

        $hasNotAcceptedUser = $this->contractRepo->hasNotAcceptedUsers($contract);

        if (!$hasNotAcceptedUser) {
            $contract->flag_status = "Active";
            $contract->save();

            $this->contractRepo->createContractHistory($contract, $user, "active");
            $this->contractRepo->createContractUsersHistory($contract, $user, "active");

            $arrContractUsers = $contract->users()->get()->unique("user_id")->all();

            $startContract = [
                "notification_name" => "Hello",
                "notification_memo" => "{$objProject->project_title} project's contract has started.",
                "autoClose"         => true,
                "showTime"          => 5000,
            ];

            $this->notify($startContract, $arrContractUsers);

            dispatch(new ContractLedgerJob($contract, ContractLedgerService::ACTIVATE_CONTRACT))->onQueue("ledger");

            $arrContractUsers = $contract->users()->wherePivot("contract_version", $contract->contract_version)->get();
            foreach ($arrContractUsers as $objUser) {
                Mail::to($objUser->primary_email->user_auth_email)->send(new Activated($contract, Client::app()));
            }
        }

        event(new ContractChanges($contract));

        return $contract;
    }

    /**
     * Set status of user and contract as rejected
     *
     * @param Contract $contract
     * @param User $user
     * @return Contract
     * @throws \Exception
     */
    public function rejectContract(Contract $contract, User $user): Contract {
        $objProject = $contract->project;
        $objUserDetails = $this->contractRepo->getContractUserDetails($contract, $user);

        if ($objUserDetails->contract_status !== "Pending") {
            throw new \Exception("You are already " . strtolower($objUserDetails->contract_status) . " this contract", 400);
        }

        $this->contractRepo->updateContractUser($contract, $user, "Rejected");
        $objActiveHistory = $this->contractRepo->getActiveHistory($contract);

        $arrContractUsers = $contract->users()->wherePivot("contract_version", $contract->contract_version)->get();
        foreach ($arrContractUsers as $objUser) {
            Mail::to($objUser->primary_email->user_auth_email)->send(new Rejected($contract, Client::app(), $user->name));
        }

        if ($contract->flag_status == "Modifying" && isset($objActiveHistory)) {
            $contract->contract_version = $objActiveHistory->contract_state["contract_version"];
            $contract->flag_status = "Active";
            foreach ($arrContractUsers as $objUser) {
                Mail::to($objUser->primary_email->user_auth_email)->send(new Activated($contract, Client::app()));
            }
        } else {
            $contract->flag_status = "Voided";
            foreach ($arrContractUsers as $objUser) {
                Mail::to($objUser->primary_email->user_auth_email)->send(new Voided($contract, Client::app()));
            }
        }

        $contract->save();

        $this->contractRepo->createContractHistory($contract, $user, "reject");
        $this->contractRepo->createContractUsersHistory($contract, $user, "reject");

        $arrContractUsers = $contract->users()->where("users.user_id", "!=", $user->user_id)->get()
                                     ->unique("user_id")->all();

        $startContract = [
            "notification_name" => "Hello",
            "notification_memo" => "{$user->name} rejected \"{$objProject->project_title}\" project's contract.",
            "autoClose"         => true,
            "showTime"          => 5000,
        ];

        $this->notify($startContract, $arrContractUsers);

        event(new ContractChanges($contract));
        dispatch(new ContractLedgerJob($contract, ContractLedgerService::USER_REJECT_ACTION, $user))->onQueue("ledger");

        return $contract;
    }

    /**
     * @param Contract $contract
     * @param User $objUser
     * @return Contract
     * @throws \Exception
     */
    public function cancelContract(Contract $contract, User $objUser): Contract {
        if (strtolower($contract->flag_status) !== "modifying" && strtolower($contract->flag_status) !== "pending") {
            throw new \Exception("You Can Cancel Only Pending Contract.", 400);
        }

        $objActiveHistory = $this->contractRepo->getActiveHistory($contract);
        $arrContractUsers = $contract->users()->wherePivot("contract_version", $contract->contract_version)->get();

        if (isset($objActiveHistory)) {
            $contract->contract_version = $objActiveHistory->contract_state["contract_version"];
            $contract->flag_status = "Active";
            foreach ($arrContractUsers as $objUser) {
                Mail::to($objUser->primary_email->user_auth_email)->send(new Activated($contract, Client::app()));
            }
        } else {
            $contract->flag_status = "Voided";
            foreach ($arrContractUsers as $objUser) {
                Mail::to($objUser->primary_email->user_auth_email)->send(new Voided($contract, Client::app()));
            }
        }

        $contract->save();

        $this->contractRepo->createContractHistory($contract, $objUser, "void");
        $this->contractRepo->createContractUsersHistory($contract, $objUser, "void");

        $arrContractUsers = $contract->users()->where("users.user_id", "!=", $objUser->user_id)->get()
            ->unique("user_id")->all();

        $startContract = [
            "notification_name" => "Hello",
            "notification_memo" => "{$objUser->name} voided \"{$contract->project->project_title}\" project's contract.",
            "autoClose"         => true,
            "showTime"          => 5000,
        ];

        $this->notify($startContract, $arrContractUsers);

        dispatch(new ContractLedgerJob($contract, ContractLedgerService::CANCEL_CONTRACT))->onQueue("ledger");

        event(new ContractChanges($contract));

        return $contract;
    }

    public function sendReminders($objContract, $arrData) {
        $email = null;
        $params = null;

        if (isset($arrData["user_uuid"])) {
            $objContractUser = $objContract->users()
                                           ->where("contract_status", "Pending")
                                           ->where("soundblock_projects_contracts_users.user_uuid", $arrData["user_uuid"])
                                           ->first();
            if (!empty($objContractUser->emails)) {
                $email = $objContractUser->primary_email ? $objContractUser->primary_email->user_auth_email :
                    $objContractUser->emails()->first()->user_auth_email;
            }

            $objTeam = $objContract->project->team->users()->where("soundblock_projects_teams_users.user_uuid", $arrData["user_uuid"])
                ->first();

            $params = [
                "Role"   => $objTeam->pivot->user_role,
                "Payout" => $objContractUser->pivot->user_payout . "%",
            ];
        } else {
            $objContractUser = $objContract->contractInvites()->where("contract_status", "!=", "Accepted")
               ->where("soundblock_projects_contracts_users.invite_uuid", $arrData["invite_uuid"])->first();

            $email = $objContractUser->invite_email;
            
            $params = [
                "Role"   => $objContractUser->invite_role,
                "Payout" => $objContractUser->invite_payout . "%",
            ];
        }

        if (empty($objContractUser)) {
            throw new \Exception("Member not found or already accepted contract.", 400);
        }

        $timeFromDb = $objContractUser->pivot->stamp_remind;
        $dif = time() - $timeFromDb;

        if ($dif > 86400) {
            if ($email) {
                Mail::to($email)->send(new RemindInviteContract($objContract->project, Client::app(), $params));
                $objContractUser->contracts()
                                ->where("soundblock_projects_contracts_users.contract_uuid", $objContract->contract_uuid)
                                ->update([
                                    "soundblock_projects_contracts_users.stamp_remind" => time(),
                                ]);
            }
        } else {
            throw new \Exception("You Can Send Reminders One Time Per 24 Hours.", 400);
        }

        return (true);
    }

    private function acceptServiceInvite(AccountModel $objAccount, User $objUser){
        $objUser->accounts()->updateExistingPivot($objAccount->account_id, [
            "flag_accepted" => true,
        ]);

        Mail::to($objAccount->user->primary_email->user_auth_email)->send(new ConfirmInvite(Client::app(), $objUser->name, $objAccount));

        $data = [
            "notification_name" => "Hello",
            "notification_memo" => "User {$objUser->name} accepted invitation to your account {$objAccount->account_name}.",
            "autoClose"         => true,
            "showTime"          => 5000,
        ];
        $this->notify($data, $objAccount->user);

        return $objAccount;
    }

    /**
     * @param array $data
     * @param $users
     */
    private function notify(array $data, $users) {
        $app = Client::app();
        $flags = [
            "notification_state" => "unread",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];

        if (is_array($users)) {
            foreach ($users as $user) {
                if ($user instanceof User) {
                    event(new PrivateNotification($user, $data, $flags, $app));
                }
            }
        } else if ($users instanceof User) {
            event(new PrivateNotification($users, $data, $flags, $app));
        }
    }
}
