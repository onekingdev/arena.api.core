<?php

namespace App\Http\Transformers\Soundblock;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Account;
use App\Models\Soundblock\Projects\ProjectDraft as ProjectDraftModel;
use App\Traits\StampCache;

class ProjectDraft extends BaseTransformer {
    use StampCache;

    public function transform(ProjectDraftModel $objDraft) {
        $arrDraftInfo = $objDraft->draft_json;

        if (isset($arrDraftInfo["payment"])) {
            unset($arrDraftInfo["payment"]);
        }

        if (isset($arrDraftInfo["project"]["project_file"])) {
            unset($arrDraftInfo["project"]["project_file"]);
        }
        $response = [
            "draft_uuid" => $objDraft->draft_uuid,
            "draft_json" => $arrDraftInfo,
        ];

        return (array_merge($response, $this->stamp($objDraft)));
    }

    public function includeAccount(ProjectDraftModel $objDraft) {
        return ($this->item($objDraft->account, new Account));
    }
}
