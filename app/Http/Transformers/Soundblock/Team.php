<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\User\User;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Projects\Team as TeamModel;

class Team extends BaseTransformer
{
    use StampCache;

    /**
     * @param TeamModel $objTeam
     * @return array
     */
    public function transform(TeamModel $objTeam)
    {
        $response = [
            "team_uuid" => $objTeam->team_uuid,
        ];

        return(array_merge($response, $this->stamp($objTeam)));
    }

    public function includeProject(TeamModel $objTeam)
    {
        return($this->item($objTeam->project, new Project));
    }

    public function includeUsers(TeamModel $objTeam)
    {
        return($this->collection($objTeam->users, new User));
    }
}
