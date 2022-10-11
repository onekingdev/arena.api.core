<?php

namespace App\Repositories\Soundblock;

use App\Models\BaseModel;
use App\Models\Users\User;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Projects\ProjectDraft as ProjectDraftModel;

class ProjectDraft extends BaseRepository {

    /**
     * @param ProjectDraftModel $projectDraft
     * @return void
     */
    public function __construct(ProjectDraftModel $projectDraft) {
        $this->model = $projectDraft;
    }

    public function findDraftsByAccounts(array $arrAccounts, User $objUser){
        return ($this->model->where(BaseModel::STAMP_CREATED_BY, $objUser->user_id)->whereIn("account_uuid", $arrAccounts)->with("account")->orderBy("stamp_created_at", "desc")->paginate(10));
    }
}
