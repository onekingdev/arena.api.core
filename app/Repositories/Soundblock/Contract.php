<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\{Soundblock\Projects\Contracts\Contract as ContractModel, Soundblock\Projects\Project, Users\User};

class Contract extends BaseRepository {
    /**
     * ContractRepository constructor.
     * @param ContractModel $objContract
     */
    public function __construct(ContractModel $objContract) {
        $this->model = $objContract;
    }

    /**
     * @param Project $objProject
     * @param bool $blFail
     * @return Model|ContractModel
     */
    public function findLatestByProject(Project $objProject, bool $blFail = true): ?ContractModel {
        $objBuilder = $objProject->contracts()->whereNull(ContractModel::STAMP_ENDS)
            ->orderBy(ContractModel::STAMP_BEGINS, "desc");

        if($blFail) {
            return $objBuilder->firstOrFail();
        }

        return $objBuilder->first();
    }

    /**
     * @param User $objUser
     * @param Project $objProject
     * @param array $arrContractStatus
     *
     * @return null|ContractModel
     */
    public function findByUserAndStatus(User $objUser, Project $objProject, array $arrContractStatus = []): ?ContractModel {
        $objLatestContract = $this->findLatestByProject($objProject, false);
        if (!$objLatestContract)
            return(null);
        /** @var \Illuminate\Database\Query\Builder */
        $queryBuilder = $objUser->contracts()->wherePivot("contract_id", $objLatestContract->contract_id)
            ->wherePivot("contract_version", $objLatestContract->contract_version)->first();

        if (is_null($queryBuilder)) {
            return null;
        }

        if (!empty($arrContractStatus)) {
            $arrContractStatus = array_map([Util::class, "ucLabel"], $arrContractStatus);
            $queryBuilder->wherePivotIn("contract_status", $arrContractStatus);
        }

        return($queryBuilder->first()->load(["account"])->makeHidden(["account_uuid"]));
    }

    public function getCurrentCycle(ContractModel $contract) {
        return $contract->users()->max("contract_version");
    }

    public function getActiveHistory(ContractModel $contract) {
        return $contract->history()->where("history_event", "active")->latest()->first();
    }

    public function getUsersByCycle(ContractModel $contract, ?int $intCycle = null) {
        if (is_null($intCycle)) {
            $intCycle = $this->getCurrentCycle($contract);
        }

        return $contract->users()->wherePivot("contract_version", $intCycle)->get();
    }

    public function getDeletedUsers(ContractModel $contract, array $arrUsers, int $intCycle) {
        return $contract->users()->whereNotIn("users.user_uuid", $arrUsers)
            ->wherePivot("contract_version", $intCycle)
            ->where("flag_action", "!=", "delete")->get();
    }

    /**
     * @param ContractModel $contract
     * @param User $user
     * @return \Illuminate\Support\HigherOrderCollectionProxy|mixed
     * @throws \Exception
     */
    public function getContractUserDetails(ContractModel $contract, User $user) {
        $intCurrentCycle = $this->getCurrentCycle($contract);
        $objUser = $contract->users()->wherePivot("contract_version", $intCurrentCycle)->find($user->user_id);

        if(is_null($objUser)) {
            throw new \Exception("This user is not contract member.", 401);
        }

        return $objUser->pivot;
    }

    public function checkUserExist(ContractModel $contract, User $user) {
        return $contract->whereHas("users", function (Builder $query) use ($user) {
            $query->where("users.user_id", $user->user_id);
        })->exists();
    }

    /**
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function checkUserInProjectContracts(User $user, Project $project) {
        return $user->contracts()->whereHas("project", function (Builder $query) use ($project) {
            $query->where("project_id", $project->project_id);
        })->exists();
    }

    /**
     * @param ContractModel $contract
     *
     * @return bool
     */
    public function canModify(ContractModel $contract)
    {
        return(strtolower($contract->flag_status) != "modifying");
    }

    /**
     * @param ContractModel $contract
     * @return bool
     */
    public function hasNotAcceptedUsers(ContractModel $contract): bool {
        $intCurrentCycle = $this->getCurrentCycle($contract);
        $contractInvites = $contract->contractInvites()->wherePivot("contract_status", "!=", "Accepted")
            ->wherePivot("contract_version", $intCurrentCycle)->exists();
        $contractUsers = $contract->users()->wherePivot("contract_status", "!=", "Accepted")
            ->wherePivot("contract_version", $intCurrentCycle)->exists();

        return ($contractInvites == true || $contractUsers == true);
    }

    public function createContractHistory(ContractModel $contract, User $user, string $historyEvent) {
        return $contract->history()->create([
            "row_uuid"       => \Util::uuid(),
            "user_id"        => $user->user_id,
            "user_uuid"      => $user->user_uuid,
            "contract_uuid"  => $contract->contract_uuid,
            "contract_state" => $contract->makeVisible(["contract_id", "account_id", "project_id"])
                ->makeHidden("users")->toArray(),
            "history_event"  => $historyEvent,
        ]);
    }

    public function createContractUsersHistory(ContractModel $contract, User $user, string $historyEvent) {
        return $contract->usersHistory()->create([
            "row_uuid"             => \Util::uuid(),
            "user_id"              => $user->user_id,
            "user_uuid"            => $user->user_uuid,
            "contract_uuid"        => $contract->contract_uuid,
            "contract_users_state" => $contract->users()->withPivot("user_payout")->get()
                ->makeVisible(["user_id", "pivot"])->toArray(),
            "history_event"        => $historyEvent,
            "contract_version"           => $contract->contract_version,
        ]);
    }

    /**
     * @param ContractModel $contract
     * @param User $user
     * @param string $contractStatus
     * @return int
     */
    public function updateContractUser(ContractModel $contract, User $user, string $contractStatus) {
        $intCurrentCycle = $this->getCurrentCycle($contract);

        return $contract->users()->wherePivot("contract_version", $intCurrentCycle)->updateExistingPivot($user->user_id, [
            "contract_status" => $contractStatus,
        ]);
    }
}
