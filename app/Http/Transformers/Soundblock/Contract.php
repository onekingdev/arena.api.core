<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\{BaseModel, Soundblock\Projects\Contracts\Contract as ContractModel};

class Contract extends BaseTransformer
{
    use StampCache;

    public function transform(ContractModel $objContract)
    {

        $response = [
            "contract_uuid" => $objContract->contract_uuid,
            "flag_status" => $objContract->flag_status,
            BaseModel::STAMP_CREATED => $objContract->stamp_created,
            BaseModel::STAMP_UPDATED => $objContract->stamp_updated,
        ];

        if ($objContract->pivot) {
            $response["user_payout"] = $objContract->pivot->user_payout;
        }

        return($response);
    }

    public function includeProject(ContractModel $objContract) {
        return $this->item($objContract->project, new Project());
    }

    public function includeUsers(ContractModel $objContract) {
        $users = $objContract->users()->wherePivot("contract_version", $objContract->contract_version)->get();

        return $this->collection($users, new ContractUser($objContract->project, ["emails", "permissionsInGroup"]));
    }

    public function includeContractInvites(ContractModel $objContract) {
        $invites = $objContract->contractInvites()->wherePivot("contract_version", $objContract->contract_version)->get();

        return $this->collection($invites, new InviteContract());
    }
}
