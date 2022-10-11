<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\{Projects\Contracts\Contract,
    Projects\Project,
    Projects\Team as TeamModel,
    Accounts\Account,
    Invites};

class Invite extends BaseTransformer {
    use StampCache;

    public function transform(Invites $objInvite) {
        $arrAccount = [];
        /** @var Contract|TeamModel $objContract */
        $objContract = $objInvite->invitable;
        /** @var Project $objProject */
        $objProject = $objContract->project;
        /** @var Account $objAccount */
        $objAccount = $objProject->account()->where("flag_status", "active")->first();

        if (is_object($objAccount)) {
            $arrAccount = [
                "account_uuid" => $objAccount->account_uuid,
                "account_name" => $objAccount->account_name,
            ];
        }

        return [
            "invite_uuid"  => $objInvite->invite_uuid,
            "invite_hash"  => $objInvite->invite_hash,
            "invite_email" => $objInvite->invite_email,
            "invite_name"  => $objInvite->invite_name,
            "invite_role"  => $objInvite->invite_role,
            "payout"       => $objInvite->invite_payout,
            "project"      => [
                "project_uuid"    => $objProject->project_uuid,
                "project_title"   => $objProject->project_title,
                "project_type"    => $objProject->project_type,
                "project_date"    => $objProject->project_date,
                "project_artwork" => $objProject->artwork,
            ],
            "account"      => $arrAccount,
        ];
    }
}
