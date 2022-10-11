<?php

namespace App\Services\Common;

use Mail;
use Util;
use Client;
use Exception;
use Carbon\Carbon;
use App\Events\Common\CreateAccount;
use App\Mail\Soundblock\ConfirmInvite;
use App\Events\Common\PrivateNotification;
use App\Mail\Soundblock\Welcome as WelcomeEmail;
use App\Repositories\Soundblock\Reports\Bandwidth;
use App\Repositories\Soundblock\Reports\DiskSpace;
use App\Services\Soundblock\Project as ProjectService;
use App\Services\Core\Auth\AuthGroup as AuthGroupService;
use App\Repositories\Common\Account as AccountRepository;
use App\Services\Common\AccountPlan as AccountPlanService;
use App\Repositories\Soundblock\Project as ProjectRepository;
use App\Services\Core\Auth\AuthPermission as AuthPermissionService;
use App\Repositories\Core\Auth\{AuthGroup, AuthGroup as AuthGroupRepository, AuthPermission};
use App\Models\{BaseModel, Users\User, Soundblock\Accounts\Account, Soundblock\Data\PlansType as PlansTypeModel};

class Common {
    /** @var AccountRepository */
    protected AccountRepository $accountRepo;
    /** @var AuthPermission */
    protected AuthPermission $permRepo;
    /** @var AuthGroup */
    protected AuthGroup $groupRepo;
    /** @var ProjectService */
    private ProjectService $projectService;
    /** @var ProjectRepository */
    private ProjectRepository $projectRepo;
    /** @var AccountPlanService */
    private AccountPlanService $accountPlanService;
    /** @var Bandwidth */
    private Bandwidth $bandwidthRepository;
    /** @var DiskSpace */
    private DiskSpace $diskSpaceRepository;

    /**
     * @param AuthPermission $permRepo
     * @param AuthGroup $groupRepo
     * @param AccountRepository $accountRepo
     * @param ProjectService $projectService
     * @param ProjectRepository $projectRepo
     * @param AccountPlanService $accountPlanService
     * @param Bandwidth $bandwidthRepository
     * @param DiskSpace $diskSpaceRepository
     */
    public function __construct(AuthPermission $permRepo, AuthGroup $groupRepo, AccountRepository $accountRepo,
                                ProjectService $projectService, ProjectRepository $projectRepo,
                                AccountPlanService $accountPlanService, Bandwidth $bandwidthRepository,
                                DiskSpace $diskSpaceRepository) {
        $this->permRepo = $permRepo;
        $this->groupRepo = $groupRepo;
        $this->accountRepo = $accountRepo;
        $this->projectRepo = $projectRepo;
        $this->projectService = $projectService;
        $this->accountPlanService = $accountPlanService;
        $this->bandwidthRepository = $bandwidthRepository;
        $this->diskSpaceRepository = $diskSpaceRepository;
    }

    public function findAll($perPage = 10, array $arrSort = []) {
        $objBuilder = Account::with("plans:plan_id,account_id,service_date,plan_cost,plan_type,plan_uuid");

        if (isset($arrSort["sort_plan"])) {
            $objBuilder->leftJoin("soundblock_accounts_plans", function ($query) {
                $query->on("soundblock_accounts.account_id", "soundblock_accounts_plans.account_id")->where("flag_active", true);
            })->orderBy("soundblock_accounts_plans.plan_type", $arrSort["sort_plan"]);
        }

        if (isset($arrSort["sort_created_at"])) {
            $objBuilder->orderBy("stamp_created_at", $arrSort["sort_created_at"]);
        }

        if (!intval($perPage)) {
            $perPage = 10;
        }

        $objAccounts = $objBuilder->paginate($perPage)->withPath(route("get-accounts"));

        $objAccounts->each(function ($account){
            $account->makeVisible([
                BaseModel::STAMP_CREATED,
                BaseModel::STAMP_UPDATED,
                BaseModel::STAMP_CREATED_BY
            ]);
        });

        return ($objAccounts);
    }

    /**
     * @param User $objUser
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function findByUser(User $objUser) {
        $arrAccounts = collect();
        $objUser->load(["groups" => function ($q) {
            $q->where("core_auth_groups.group_name", "like", "App.Soundblock.Account.%");
        }]);
        $arrUserGroups = $objUser->groups->unique("group_id");

        foreach ($arrUserGroups as $objGroup) {
            $account = Util::uuid($objGroup->group_name);

            if ($account) {
                $arrAccounts->push($this->find($account));
            }
        }

        $arrAccounts = $arrAccounts->merge($objUser->accounts()->wherePivot("flag_accepted", true)->get())
           ->unique("account_uuid");

        return ($arrAccounts);
    }

    public function find($id, bool $bnFailure = true) {
        return ($this->accountRepo->find($id, $bnFailure));
    }

    public function findByUserWithCreatingPermission(User $objUser) {
        $arrAccounts = collect();
        $objPerm = $this->permRepo->findByName("App.Soundblock.Account.Project.Create");

        $objUser->load(["groupsWithPermissions" => function ($query) use ($objPerm) {
            $query->where("group_name", "like", "App.Soundblock.Account.%");
            $query->wherePivot("permission_value", 1);
            $query->wherePivot("permission_id", $objPerm->permission_id);
        }]);

        $arrUserGroups = $objUser->groupsWithPermissions->unique("group_id");
        unset($objUser->groupsWithPermissions);

        foreach ($arrUserGroups as $objGroup) {
            $account = Util::uuid($objGroup->group_name);

            if ($account) {
                $arrAccounts->push($this->find($account));
            }
        }

        return $arrAccounts;
    }

    /**
     * @param User $objUser
     * @param $strServiceUuid
     * @return Account
     * @throws Exception
     */
    public function findUsersAccount(User $objUser, $strServiceUuid) {
        $reqGroupName = "App.Soundblock.Account." . $strServiceUuid;
        $objProjectGroup = $this->groupRepo->checkUserGroup($objUser, $reqGroupName);

        if (is_null($objProjectGroup)) {
            return $this->getActiveUserAccount($objUser);
        }

        $objAccount = $this->accountRepo->find($strServiceUuid);

        return ($objAccount);
    }

    public function getActiveUserAccount(User $objUser) {
        $objAccount = $this->accountRepo->getActiveUserAccount($objUser);

        if (is_null($objAccount)) {
            throw new \Exception("Account Not Found.", 404);
        }

        return $objAccount;
    }

    public function getMonthlyUserReport(Account $objAccount) {
        return $this->accountRepo->getMonthlyReport($objAccount);
    }

    public function getAccountInvites(User $objUser): array {
        $invitedServices = $objUser->accounts()->where("flag_accepted", false)
            ->wherePivotNull("stamp_deleted")->get();
        $arrProjectId = $objUser->teams()->pluck("project_id")->toArray();
        $invitedServices->load(["projects" => function ($query) use ($arrProjectId) {
            $query->whereIn("project_id", $arrProjectId);
        }]);

        foreach ($invitedServices as $invite) {
            $invite->makeHidden("pivot");

            $invite->projects->each(function ($project) {
                $project->makeHidden("account");
            });
        }

        return $invitedServices->toArray();
    }

    /**
     * @param string $name
     * @return array|null
     */
    public function autocomplete(string $name) {
        $returnData = [];
        $objAccounts = $this->accountRepo->findAllLikeName($name, "account_name");

        if ($objAccounts) {
            foreach ($objAccounts as $account) {
                $returnData[] = ["name" => $account->account_name, "account_uuid" => $account->account_uuid];
            }

            return ($returnData);
        }

        return null;
    }

    public function typeahead(array $arrData) {
        return $this->accountRepo->typeahead($arrData);
    }

    /**
     * @param Account $objAccount
     * @param User $objUser
     * @return bool
     */
    public function checkIsAccountMember(Account $objAccount, User $objUser): bool {
        $isServiceUser = $objUser->accounts()->wherePivot("flag_accepted", true)
            ->where("soundblock_accounts.account_id", $objAccount->account_id)->exists();
        $isServiceOwner = $objUser->account()->where("account_id", $objAccount->account_id)->exists();

        return $isServiceOwner || $isServiceUser;
    }

    public function buildAccountReport(Account $objAccount, string $strDateStart, string $strDateEnd) {
        $arrReport = [];
        $objDateStart = Carbon::parse($strDateStart)->startOfDay();
        $objDateEnd = Carbon::parse($strDateEnd)->startOfDay();

        if ($objDateEnd->gt(Carbon::now()->startOfDay())) {
            $objDateEnd = Carbon::now()->startOfDay();
        }

        $arrProjectsId = $objAccount->projects()->pluck("project_id")->toArray();

        $objBandwidthReport = $this->bandwidthRepository->getBandwidthReport($arrProjectsId, $strDateStart, $strDateEnd);
        $objDiskspaceReport = $this->diskSpaceRepository->getDiskspaceReport($arrProjectsId, $strDateStart, $strDateEnd);

        $arrBandwidthReport = $objBandwidthReport->keyBy("report_date");
        $arrDiskspaceReport = $objDiskspaceReport->keyBy("report_date");

        foreach ($objDateStart->range($objDateEnd, 1, "day") as $objDay) {
            $strDay = $objDay->format("Y-m-d");

            $arrReport[$strDay] = [
                "diskspace" => isset($arrDiskspaceReport[$strDay]) ?
                    floatval(number_format($arrDiskspaceReport[$strDay]->report_value / 1e+6, 2)) : 0,
                "bandwidth" => isset($arrBandwidthReport[$strDay]) ?
                    floatval(number_format($arrBandwidthReport[$strDay]->report_value / 1e+6, 2)) : 0
            ];
        }

        return $arrReport;
    }


    /**
     * @param string $accountName
     * @param PlansTypeModel $objPlanType
     * @param User $objUser
     * @return array
     * @throws Exception
     */
    public function createNew(string $accountName, PlansTypeModel $objPlanType, User $objUser): array
    {
        $objAccount = $objUser->userAccounts()->where("account_name", $accountName)->first();

        if ($objAccount) {
            throw new \Exception("Account with this name already exist.", 400);
        }

        $objAccount = $this->accountRepo->create([
            "user_id" => $objUser->user_id,
            "user_uuid" => $objUser->user_uuid,
            "account_name" => $accountName,
        ]);

        $objUser->accounts()->attach($objAccount->account_id, [
            "row_uuid"      => Util::uuid(),
            "account_uuid"  => $objAccount->account_uuid,
            "user_uuid"     => $objUser->user_uuid,
            "flag_accepted" => true
        ]);

        event(new CreateAccount([
            "group_type" => "account",
            "object"     => $objAccount,
            "user"       => $objUser,
        ]));

        Mail::to($objUser->primary_email->user_auth_email)->send(new WelcomeEmail(Client::app(), $objAccount));

        $objAccountPlan = $this->accountPlanService->create($objAccount, $objPlanType);

        return [$objAccount, $objAccountPlan];
    }

    public function update(Account $objAccount, array $arrParams): Account {
        $arrAccount = [];

        if (isset($arrParams["account_plan_name"])) {
            $arrAccount["account_name"] = $arrParams["account_plan_name"];
        }

        $objNewService = $this->accountRepo->update($objAccount, $arrAccount);

        return ($objNewService);
    }

    public function updateName(Account $objAccount, string $strName): Account {
        return ($this->accountRepo->updateAccountName($objAccount, $strName));
    }

    public function acceptInvite(Account $objAccount, User $objUser) {
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

    public function rejectInvite(Account $objAccount, User $objUser): Account {
        $arrProjectIds = $objAccount->projects()->pluck("project_uuid");
        $objUser->accounts()->updateExistingPivot($objAccount->account_id, [
            "stamp_deleted"    => time(),
            "stamp_deleted_at" => now(),
            "stamp_deleted_by" => $objUser->user_id,
        ]);

        $arrUserTeams = $objUser->teams()->whereIn("project_uuid", $arrProjectIds)->get();

        foreach ($arrUserTeams as $team) {
            $objUser->teams()->updateExistingPivot($team, [
                "stamp_deleted"    => time(),
                "stamp_deleted_at" => now(),
                "stamp_deleted_by" => $objUser->user_id,
            ]);
        }

        foreach ($arrProjectIds as $projectUuid) {
            $strGroupName = "App.Soundblock.Project.{$projectUuid}";
            $objGroup = $this->groupRepo->findByName($strGroupName);
            $this->groupRepo->detachUserFromGroup($objUser, $objGroup);
        }

        Mail::to($objAccount->user->primary_email->user_auth_email)->send(new ConfirmInvite(Client::app(), $objUser->name, $objAccount, false));

        $data = [
            "notification_name" => "Hello",
            "notification_memo" => "User {$objUser->name} declined invitation to your account {$objAccount->account_name}.",
            "autoClose"         => true,
            "showTime"          => 5000,
        ];
        $this->notify($data, $objAccount->user);

        return $objAccount;
    }

    /**
     * @param User $objUser
     * @param string $account
     * @return bool
     * @throws Exception
     */
    public function detachUser(User $objUser, string $account): bool {
        $authGroupService = resolve(AuthGroupService::class);
        $authPermissionService = resolve(AuthPermissionService::class);
        $authGroupRepo = resolve(AuthGroupRepository::class);
        $objAccount = $this->find($account);
        $boolResult = $this->accountRepo->checkUserAccount($objAccount, $objUser->user_uuid);

        if (!$boolResult) {
            throw new Exception("User hasn't this account.", 400);
        }

        $objProjects = $this->projectRepo->findAllByUserAndAccount($account, $objUser->user_uuid);

        if ($objProjects) {
            $this->projectService->detachUserFromProjects($objUser, $account, $objProjects->pluck("project_uuid")->toArray());
        }

        $this->accountRepo->detachUser($objAccount, $objUser);
        $objGroup = $authGroupRepo->findByAccount($objAccount);
        $authGroupService->detachUsersFromGroup(collect([$objUser]), $objGroup);
        $authPermissionService->detachUserPermissionByGroup($objGroup, $objUser);

        return (true);
    }

    /**
     * @param Account $objAccount
     * @return bool|null
     * @throws Exception
     */
    public function deleteAccount(Account $objAccount){
        return ($objAccount->delete());
    }

    private function notify(array $data, User $objUser){
        $app = Client::app();
        $flags = [
            "notification_state" => "unread",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];
        event(new PrivateNotification($objUser, $data, $flags, $app));
    }
}
