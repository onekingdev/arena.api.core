<?php

namespace App\Repositories\Common;

use Util;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\{
    BaseModel,
    Soundblock\Accounts\AccountTransaction,
    Users\User,
    Soundblock\Accounts\Account as AccountModel};

class Account extends BaseRepository {
    /** @var AccountTransaction */
    private AccountTransaction $accountTransactionModel;

    /**
     * @param AccountModel $account
     * @param AccountTransaction $accountTransactionModel
     */
    public function __construct(AccountModel $account, AccountTransaction $accountTransactionModel) {
        $this->accountTransactionModel = $accountTransactionModel;
        $this->model = $account;
    }

    /**
     * @param string $term
     * @param string $column
     * @return SupportCollection
     */
    public function findAllLikeName(string $term, string $column = "account_name") {
        $term = Util::lowerLabel($term);
        return ($this->model->whereRaw("lower(" . $column . ") like (?)", ["%{$term}%"])->get());
    }

    public function getActiveUserAccount(User $objUser): ?AccountModel {
        return $objUser->account()->active()->latest()->first();
    }

    /**
     * @param User $objUser
     * @param array $arrProjectUuids
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersAccountsProjects(User $objUser, array $arrProjectUuids){
        return ($objUser->accounts()->with("projects", function ($query) use ($arrProjectUuids) {
            $query->whereIn("soundblock_projects.project_uuid", $arrProjectUuids);
        })->get());
    }

    public function getMonthlyReport(AccountModel $objAccount) {
        $objDate = now()->subMonths(12)->setDay(1);

        $report = $this->accountTransactionModel->where("account_id", $objAccount->account_id)
                    ->whereDate("soundblock_accounts_transactions.stamp_created_at", ">", $objDate)
                    ->selectRaw("MONTH(soundblock_accounts_transactions.stamp_created_at) as month")
                    ->selectRaw("ROUND(SUM(soundblock_accounts_transactions.transaction_amount), 2) as amount")
                    ->groupByRaw("MONTH(soundblock_accounts_transactions.stamp_created_at)")->get();

        return ($report);
    }

    public function typeahead(array $arrData) {
        $objQuery = $this->model->newQuery();

        if (isset($arrData["account"])) {
            $objQuery = $objQuery->where("account_name", "like", "%{$arrData["account"]}%");
        }

        if (isset($arrData["project"])) {
            $objQuery = $objQuery->whereHas("projects", function (Builder $query) use ($arrData) {
                $query->where("project_uuid", $arrData["project"]);
            });
        }

        if (isset($arrData["artist"])) {
            $objQuery = $objQuery->whereHas("artists", function (Builder $query) use ($arrData) {
                $query->where("artist_uuid", $arrData["artist"]);
            });
        }

        return $objQuery->get();
    }

    /**
     * @param AccountModel $objAccount
     * @param string $user
     * @return bool
     */
    public function checkUserAccount(AccountModel $objAccount, string $user){
        return ($objAccount->users()->where("soundblock_accounts_users.user_uuid", $user)->exists());
    }

    /**
     * @param AccountModel $objAccount
     * @param array $projects
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function checkAccountsProjects(AccountModel $objAccount, array $projects){
        return ($objAccount->projects()->whereIn("project_uuid", $projects)->get());
    }

    /**
     * @param AccountModel $objAccount
     * @param string $dateStart
     * @return int
     */
    public function accountUsersCount(AccountModel $objAccount, string $dateStart){
        return (
            $objAccount->users()->where(function ($query) use ($dateStart) {
                $query->whereNull("soundblock_accounts_users." . BaseModel::DELETED_AT)
                    ->orWhere("soundblock_accounts_users." . BaseModel::DELETED_AT, ">=", $dateStart);
            })->where("soundblock_accounts_users.flag_accepted", true)->count()
        );
    }

    public function accountUsersCountWithoutDeleted(AccountModel $objAccount){
        return (
            $objAccount->users()
                ->whereNull("soundblock_accounts_users." . BaseModel::DELETED_AT)
                ->where("soundblock_accounts_users.flag_accepted", true)
                ->count()
        );
    }

    public function updateAccountName(AccountModel $objAccount, string $accountName): AccountModel {
        $objAccount->account_name = $accountName;
        $objAccount->save();

        return $objAccount;
    }

    /**
     * @param AccountModel $objAccount
     * @param User $objUser
     * @return int
     */
    public function detachUser(AccountModel $objAccount, User $objUser){
        return (
        $objAccount->users()->where("soundblock_accounts_users.user_uuid", $objUser->user_uuid)->update([
            "soundblock_accounts_users." . BaseModel::DELETED_AT       => Util::now(),
            "soundblock_accounts_users." . BaseModel::STAMP_DELETED    => time(),
            "soundblock_accounts_users." . BaseModel::STAMP_DELETED_BY => $objUser->user_id,
        ])
        );
    }

}
