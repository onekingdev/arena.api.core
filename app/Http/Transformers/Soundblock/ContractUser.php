<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\{
    Auth\OnlyAuthGroup,
    BaseTransformer,
    User\Email
};
use App\Models\{Soundblock\Projects\Project, Soundblock\Projects\Team, Users\User};

class ContractUser extends BaseTransformer
{
    use StampCache;
    /**
     * @var Project
     */
    private $project;

    /**
     * ContractTransformer constructor.
     * @param Project $project
     * @param array $arrIncludes
     */
    public function __construct(Project $project, array $arrIncludes = []) {
        $this->project = $project;
        parent::__construct($arrIncludes);
    }

    public function transform(User $objUser)
    {
        $role = null;
        /** @var Team $team*/
        $team = $this->project->team;

        if (isset($team)) {
            $member = $team->users()->find($objUser->user_id);

            if(isset($member)) {
                $role = $member->pivot->user_role;
            }
        }

        $response = [
            "user_uuid" => $objUser->user_uuid,
            "name" => $objUser->name,
            "user_role" => $role,
            "contract_details" => [
                "user_payout" => intVal($objUser->pivot->user_payout),
                "contract_status" => $objUser->pivot->contract_status
            ]
        ];

        $stamps = $this->stamp($objUser);

        return array_merge($response, $stamps);
    }

    public function includeEmails(User $objUser) {
        $query =  $objUser->emails()->where("flag_primary", true);

        return($this->item($query->first(), new Email()));
    }

    public function includePermissionsInGroup(User $objUser) {
        return($this->collection($objUser->groupsWithPermissions, new OnlyAuthGroup));

    }
}
