<?php

namespace App\Repositories\Soundblock;

use App\Repositories\Soundblock\Data\ProjectsRoles;
use Util;
use Auth;
use Constant;
use App\Models\{BaseModel, Soundblock\Data\ProjectsRole, Users\User, Soundblock\Projects\Team as TeamModel};
use App\Repositories\BaseRepository;

class Team extends BaseRepository {
    /**
     * @var \App\Repositories\Soundblock\Data\ProjectsRoles
     */
    private ProjectsRoles $rolesRepository;

    /**
     * @param TeamModel $team
     * @return void
     */
    public function __construct(TeamModel $team, ProjectsRoles $rolesRepository) {
        $this->model = $team;
        $this->rolesRepository = $rolesRepository;
    }

    /**
     * @param TeamModel $team
     * @param \Illuminate\Database\Eloquent\Collection $arrInfo
     * @return TeamModel
     * @throws \Exception
     */
    public function addMembers(TeamModel $team, $arrInfo) {
        foreach ($arrInfo as $info) {
            /** @var User $user */
            $user = $info["email"]->user;
            $intVal = $this->memberExists($team, $user);
            switch ($intVal) {
                case Constant::NOT_EXIST:
                {
                    $team->users()->attach($user->user_id, [
                        "row_uuid"                  => Util::uuid(),
                        "user_uuid"                 => $user->user_uuid,
                        "team_uuid"                 => $team->team_uuid,
                        "user_payout"               => isset($info["user_payout"]) ? $info["user_payout"] : null,
                        "user_role"                 => Util::ucLabel($info["user_role"]),
                        BaseModel::STAMP_CREATED    => time(),
                        BaseModel::STAMP_CREATED_BY => Auth::id(),
                        BaseModel::STAMP_UPDATED    => time(),
                        BaseModel::STAMP_UPDATED_BY => Auth::id(),
                    ]);
                }

                case Constant::EXIST:
                {
                    $team->users()->updateExistingPivot($user->user_id, [
                        "user_payout"               => isset($info["user_payout"]) ? $info["user_payout"] : null,
                        "user_role"                 => Util::ucLabel($info["user_role"]),
                        BaseModel::STAMP_UPDATED    => time(),
                        BaseModel::STAMP_UPDATED_BY => Auth::id(),
                        BaseModel::DELETED_AT       => null,
                        BaseModel::STAMP_DELETED    => null,
                        BaseModel::STAMP_DELETED_BY => null,
                    ]);
                }
            }
        }
        return ($team);
    }

    /**
     * @param TeamModel $team
     * @param User $user
     * @param array $option
     * @param ProjectsRole|null $objRole
     * @throws \Exception
     */
    public function addMember(TeamModel $team, User $user, array $option, ?ProjectsRole $objRole = null) {
        $isExist = $this->memberExists($team, $user);
        switch ($isExist) {
            case Constant::EXIST:
            {
                $team->users()->updateExistingPivot($user->user_id, [
                    "user_payout"               => isset($option["user_payout"]) ? $option["user_payout"] : null,
                    "role_id"                   => is_object($objRole) ? $objRole->data_id : null,
                    "role_uuid"                 => is_object($objRole) ? $objRole->data_uuid : null,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => Auth::id(),
                    BaseModel::DELETED_AT       => null,
                    BaseModel::STAMP_DELETED    => null,
                    BaseModel::STAMP_DELETED_BY => null,
                    "stamp_remind"              => time(),
                ]);
                break;
            }
            case Constant::NOT_EXIST:
            {
                $team->users()->attach($user->user_id, [
                    "row_uuid"                  => Util::uuid(),
                    "user_uuid"                 => $user->user_uuid,
                    "team_uuid"                 => $team->team_uuid,
                    "user_payout"               => isset($option["user_payout"]) ? $option["user_payout"] : null,
                    "role_id"                   => is_object($objRole) ? $objRole->data_id : null,
                    "role_uuid"                 => is_object($objRole) ? $objRole->data_uuid : null,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => Auth::id(),
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => Auth::id(),
                    BaseModel::DELETED_AT       => null,
                    BaseModel::STAMP_DELETED    => null,
                    BaseModel::STAMP_DELETED_BY => null,
                    "stamp_remind"              => time(),
                ]);
                break;
            }
        }
    }

    /**
     * @param TeamModel $objTeam
     * @param User $objUser
     * @param array $role
     * @return TeamModel
     * @throws \Exception
     */
    public function updateUserRole(TeamModel $objTeam, User $objUser, array $role) {
        $arrData = [];

        if (isset($role["role"])) {
            $arrData["user_role"] = $role["role"];
        }

        if (isset($role["user_role_id"])) {
            $objRole = $this->rolesRepository->findProjectRole($role["user_role_id"]);

            if (is_null($objRole)) {
                throw new \Exception("Invalid Role.");
            }

            $arrData["role_id"] = $objRole->data_id;
            $arrData["role_uuid"] = $objRole->data_uuid;
        }

        $objTeam->users()->updateExistingPivot($objUser, $arrData, true);

        return ($objTeam);
    }

    /**
     * @param TeamModel $team
     * @param User $user
     * @return int
     */
    protected function memberExists(TeamModel $team, User $user): int {
        $bnExists = $team->usersWithTrashed()
            ->wherePivot("user_id", $user->user_id)
            ->exists();
        if ($bnExists) {
            return (Constant::EXIST);
        } else {
            return (Constant::NOT_EXIST);
        }
    }
}
