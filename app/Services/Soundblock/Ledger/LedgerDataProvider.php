<?php

namespace App\Services\Soundblock\Ledger;

use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Files\File;
use App\Models\Soundblock\Track;
use App\Models\Soundblock\Ledger as LedgerModel;
use App\Models\Soundblock\Projects\Contracts\Contract;
use App\Models\Soundblock\Projects\Deployments\Deployment;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Projects\Team;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Users\User;
use App\Repositories\Soundblock\Ledger;
use Illuminate\Database\Eloquent\Model;

class LedgerDataProvider {
    private array $tableModels = [
        "soundblock_accounts"             => Account::class,
        "soundblock_files"                => File::class,
        "soundblock_projects_contracts"   => Contract::class,
        "soundblock_projects"             => Project::class,
        "soundblock_projects_deployments" => Deployment::class,
        "soundblock_collections"          => Collection::class,
        "soundblock_tracks"               => Track::class
    ];
    /**
     * @var Ledger
     */
    private Ledger $ledgerRepo;

    /**
     * LedgerDataProvider constructor.
     * @param Ledger $ledgerRepo
     */
    public function __construct(Ledger $ledgerRepo) {
        $this->ledgerRepo = $ledgerRepo;
    }

    public function find(string $ledger) {
        return $this->ledgerRepo->find($ledger);
    }

    /**
     * @param LedgerModel $objLedger
     * @param User $objUser
     * @return bool
     */
    public function checkAccess(LedgerModel $objLedger, User $objUser): bool {
        $strModelClass = $this->tableModels[$objLedger->table_name];
        /** @var Model $objModel */
        $objModel = resolve($strModelClass);
        $objDataProvider = $objModel->find($objLedger->table_id);

        if ($objDataProvider instanceof Account) {
            if ($objDataProvider->user_id == $objUser->user_id) {
                return true;
            }

            return $objDataProvider->users()->where("users.user_id", $objUser->user_id)->exists();
        } else {
            /** @var Team $objTeam */
            if ($objDataProvider instanceof Project) {
                $objTeam = $objDataProvider->team;
            } elseif ($objDataProvider instanceof File || $objDataProvider instanceof Track) {
                /** @var Collection $objCollection */
                $objCollection = $objDataProvider->collections()->latest()->first();
                $objProject = $objCollection->project;
                $objTeam = $objProject->team;
            } else {
                $objProject = $objDataProvider->project;
                $objTeam = $objProject->team;
            }
        }

        return $objTeam->users()->where("users.user_id", $objUser->user_id)->exists();
    }
}
