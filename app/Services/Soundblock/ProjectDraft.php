<?php

namespace App\Services\Soundblock;

use Util;
use App\Repositories\{
    Core\Auth\AuthPermission,
    Common\Account as AccountRepository,
    Soundblock\ProjectDraft as ProjectDraftRepository,
};
use App\Models\{Soundblock\Projects\ProjectDraft as ProjectDraftModel, Users\User};

class ProjectDraft {
    protected AccountRepository $accountRepo;
    protected AuthPermission $permRepo;
    protected ProjectDraftRepository $draftRepo;

    /**
     * @param AccountRepository $accountRepo
     * @param AuthPermission $permRepo
     * @param ProjectDraftRepository $draftRepo
     */
    public function __construct(AccountRepository $accountRepo, AuthPermission $permRepo, ProjectDraftRepository $draftRepo) {
        $this->permRepo    = $permRepo;
        $this->draftRepo   = $draftRepo;
        $this->accountRepo = $accountRepo;
    }

    /**
     * @param $draft
     * @param bool $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find($draft, bool $bnFailure = true) {
        return ($this->draftRepo->find($draft, $bnFailure));
    }

    /**
     * @param User $objUser
     * @return mixed
     * @throws \Exception
     */
    public function findAllByUser(User $objUser) {
        $reqPermName = "App.Soundblock.Account.Project.Create";
        $objAuthPerm = $this->permRepo->findByName($reqPermName);

        $arrGroup = $objUser->load(["groupsWithPermissions" => function ($q) use ($objAuthPerm) {
            $q->where("group_name", "like", "App.Soundblock.Account.%");
            $q->wherePivot("permission_value", 1);
            $q->wherePivot("permission_id", $objAuthPerm->permission_id);
        }])->groupsWithPermissions;

        $arrAccounts = collect();
        foreach ($arrGroup as $objGroup) {
            $account = Util::uuid($objGroup->group_name);

            if ($account) {
                $arrAccounts->push($this->accountRepo->find($account));
            }
        }

        $drafts = $this->draftRepo->findDraftsByAccounts($arrAccounts->pluck("account_uuid")->toArray(), $objUser)->toArray();
        foreach($drafts["data"] as $key => $draft) {
            if (isset($draft["draft_json"]["payment"])) {
                unset($drafts["data"][$key]["draft_json"]["payment"]);
            }

            if (isset($draft["draft_json"]["project"]["project_file"])) {
                unset($drafts["data"][$key]["draft_json"]["project"]["project_file"]);
            }
        }

        return ($drafts);
    }

    /**
     * @param array $arrParams
     * @return ProjectDraftModel
     * @throws \Exception
     */
    public function create(array $arrParams) {
        $arrDraft = [];

        $objAccount = $this->accountRepo->find($arrParams["account"], true);
        $arrDraft["account_id"] = $objAccount->account_id;
        $arrDraft["account_uuid"] = $objAccount->account_uuid;
        $arrDraft["draft_json"] = [
            "step"    => 1,
            "project" => [],
        ];

        $objDraft = $this->draftRepo->create($arrDraft);

        return ($this->putJsonField($objDraft, $arrParams));
    }

    /**
     * @param ProjectDraftModel $objDraft
     * @param array $arrParams
     * @return ProjectDraftModel
     */
    public function putJsonField(ProjectDraftModel $objDraft, array $arrParams) {
        $arrDraftJson = is_null($objDraft->draft_json) ? [] : $objDraft->draft_json;
        unset($arrParams["draft"], $arrParams["account"]);

        if (isset($arrParams["step"])) {
            $arrDraftJson["step"] = $arrParams["step"];
            unset($arrParams["step"]);
        }

        $arrDraftJson["project"] = $arrParams;

        $objDraft->draft_json = $arrDraftJson;
        $objDraft->save();

        return ($objDraft);
    }

    /**
     * @param string $draft
     * @return bool
     * @throws \Exception
     */
    public function deleteDraft(string $draft){
        $this->draftRepo->destroy($draft);

        return (true);
    }
}
