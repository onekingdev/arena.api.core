<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\{
    User\Email,
    Auth\AuthPermission
};
use League\Fractal\TransformerAbstract;
use App\Models\{
    Users\User,
    Core\Auth\AuthGroup,
    Soundblock\Accounts\Account,
    Soundblock\Projects\Contracts\Contract
};

class UserContract extends TransformerAbstract
{
    use StampCache;

    protected $objContract;
    protected $objAccount;
    protected $objAuthGroup;
    public $availableIncludes = [];
    protected $defaultIncludes = [];

    public function __construct(?array $arrIncludes = null, ?Contract $objContract = null, ?AuthGroup $objAuthGroup = null, ?Account $objAccount = null)
    {

        $this->objContract = $objContract;
        $this->objAuthGroup = $objAuthGroup;
        $this->objAccount = $objAccount;
        if (isset($arrIncludes))
        {
            foreach($arrIncludes as $item)
            {
                $item = strtolower($item);
                $this->availableIncludes []= $item;
                $this->defaultIncludes []= $item;
            }
        }
    }

    public function transform(User $objUser)
    {
        $response = [
            "user_uuid" => $objUser->user_uuid,
            "name_first" => $objUser->name_first,
            "name_middle" => $objUser->name_middle,
            "name_last" => $objUser->name_last,
        ];

        if ($this->objContract)
        {
            $objContract = $objUser->contracts()->wherePivot("contract_id", $this->objContract->contract_id)->first();

            if (isset($objContract))
            {
                $response["contract"] = [
                    "data" => [
                        "contract_uuid" => $objContract->contract_uuid,
                        "user_payout" =>  $objContract->pivot->user_payout,
                    ]
                ];
            } else {
                $response["contract"] = [];
            }
        }

        if ($this->objAccount)
        {
            $objOwner = $this->objAccount->user;
            if ($objOwner->user_id == $objUser->user_id)
            {
                $response["is_owner"] = true;
            } else {
                $response["is_owner"] = false;
            }
        }

        return(array_merge($response, $this->stamp($objUser)));
    }

    public function includePermissionsInGroup(User $objUser)
    {
        if ($this->objAuthGroup)
        {
            return($this->collection($objUser->permissionsInGroup()
                        ->wherePivot("group_id", $this->objAuthGroup->group_id)
                        ->get(), new AuthPermission));
        } else {
            return($this->collection($objUser->permissionsInGroup, new AuthPermission));
        }

    }

    public function includeEmails(User $objUser)
    {
        return($this->item($objUser->emails()->where("flag_primary", true)->first(), new Email));
    }
}
