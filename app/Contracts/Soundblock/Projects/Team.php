<?php

namespace App\Contracts\Soundblock\Projects;

use App\Models\Core\Auth\AuthGroup;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Projects\Team as TeamModel;

interface Team {
    public function find($id, ?bool $bnFailure = true);
    public function findByProject(string $project): TeamModel;
    public function getUsers(Project $objProject): TeamModel;
    public function getInvites(Project $objProject);
    public function create(Project $project): TeamModel;
    public function storeMember(array $arrParams);
    public function addMembers(TeamModel $objTeam, $arrInfo): TeamModel;
    public function update(TeamModel $objTeam, array $arrParams);
    public function delete(Project $objProject, $arrUser, AuthGroup $objAuthGroup): AuthGroup;
    public function findUsersWhereAccountPermission($objTeam, string $permission);
}
