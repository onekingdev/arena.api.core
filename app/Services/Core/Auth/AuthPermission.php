<?php

namespace App\Services\Core\Auth;

use Util;
use Auth;
use Constant;
use Exception;
use App\Exceptions\Core\Auth\AuthException;
use Illuminate\Database\Eloquent\Collection as SupportCollection;
use App\Models\{
    Core\App,
    Core\Auth\AuthGroup,
    Core\Auth\AuthPermission as AuthPermissionModel,
    BaseModel,
    Soundblock\Accounts\Account,
    Soundblock\Projects\Project,
    Users\User
};
use App\Repositories\{
    Core\Auth\AuthGroup as AuthGroupRepository,
    Core\Auth\AuthPermission as AuthPermissionRepository
};

class AuthPermission {
    /** @var AuthGroupRepository */
    protected AuthGroupRepository $groupRepo;
    /** @var AuthPermissionRepository */
    protected AuthPermissionRepository $permRepo;

    /**
     * @param AuthGroupRepository $groupRepo
     * @param AuthPermissionRepository $permRepo
     */
    public function __construct(AuthGroupRepository $groupRepo, AuthPermissionRepository $permRepo) {
        $this->permRepo = $permRepo;
        $this->groupRepo = $groupRepo;
    }

    /**
     * @param mixed $id
     * @param bool $bnFailure
     * @return AuthPermissionModel
     * @throws Exception
     */
    public function find($id, ?bool $bnFailure = true): AuthPermissionModel {
        return ($this->permRepo->find($id, $bnFailure));
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function findAll(int $perPage = 10) {
        return (AuthPermissionModel::paginate($perPage));
    }

    /**
     * @param string $strName
     * @return AuthPermissionModel|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findByName(string $strName){
        return ($this->permRepo->findByName($strName));
    }

    /**
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function findAllWhere(array $where, $field = "uuid") {
        return ($this->permRepo->findAllWhere($where, $field));
    }

    /**
     * @param AuthGroup $authGroup
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public function findAllUserPermissionsByGroup(AuthGroup $authGroup, User $user) {
        $userPermissions = $this->permRepo->findAllByUserAndGroup($user, $authGroup);

        return ($userPermissions);
    }

    /**
     * @param Account $objAccount
     * @param User $objUser
     * @return \Illuminate\Support\Collection
     */
    public function findUserPermissionByAccount(Account $objAccount, User $objUser) {
        $authGroup = $this->groupRepo->findByAccount($objAccount);
        return $this->permRepo->findAllByUserAndGroup($objUser, $authGroup);

    }

    /**
     * @param AuthPermissionModel $objAuthPerm
     * @param AuthGroup $objAuthGroup
     * @param User $objUser
     * @return bool
     */
    public function checkIfExistsUserPermission(AuthPermissionModel $objAuthPerm, AuthGroup $objAuthGroup, User $objUser): bool{
        $boolResult = $objUser->groupsWithPermissionsWithTrashed()
            ->wherePivot("group_id", $objAuthGroup->group_id)
            ->wherePivot("permission_id", $objAuthPerm->permission_id)
            ->exists();

        return ($boolResult ? Constant::EXIST : Constant::NOT_EXIST);
    }

    /**
     * @param AuthPermissionModel $objAuthPerm
     * @param AuthGroup $objAuthGroup
     * @return bool
     */
    public function checkIfExistsGroupPermission(AuthPermissionModel $objAuthPerm, AuthGroup $objAuthGroup): bool{
        $boolResult = $objAuthGroup->permissions()->where("core_auth_permissions_groups.permission_id", $objAuthPerm->permission_id)->exists();

        return ($boolResult ? Constant::EXIST : Constant::NOT_EXIST);
    }

    /**
     * @param array $arrParams
     * @param bool $bnFlagCritical
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $arrParams, bool $bnFlagCritical = false): \Illuminate\Database\Eloquent\Model {
        $arrPerm = [];

        $arrPerm["permission_name"] = $arrParams["permission_name"];
        $arrPerm["permission_memo"] = $arrParams["permission_memo"];
        $arrPerm["flag_critical"] = $bnFlagCritical;

        return ($this->permRepo->create($arrPerm));
    }

    /**
     * @param SupportCollection $arrObjPerms
     * @param AuthGroup $objAuthGroup
     * @param int $intValue
     * @return AuthGroup
     * @throws Exception
     */
    public function attachGroupPermissions(SupportCollection $arrObjPerms, AuthGroup $objAuthGroup, int $intValue = 1): AuthGroup {
        foreach ($arrObjPerms as $objAuthPerm) {
            switch ($this->checkIfExistsGroupPermission($objAuthPerm, $objAuthGroup)) {
                case Constant::EXIST :
                {
                    $objAuthGroup->permissions()->updateExistingPivot($objAuthPerm->permission_id, [
                        BaseModel::UPDATED_AT       => Util::now(),
                        BaseModel::STAMP_UPDATED    => time(),
                        BaseModel::STAMP_UPDATED_BY => Auth::id(),
                        "permission_value"          => $intValue,
                    ]);
                    break;
                }

                case Constant::NOT_EXIST :
                {
                    $objAuthGroup->permissions()->attach($objAuthPerm->permission_id, [
                        "row_uuid"                  => Util::uuid(),
                        "group_uuid"                => $objAuthGroup->group_uuid,
                        "permission_uuid"           => $objAuthPerm->permission_uuid,
                        "permission_value"          => $intValue,
                        BaseModel::STAMP_CREATED    => time(),
                        BaseModel::STAMP_CREATED_BY => Auth::id(),
                        BaseModel::STAMP_UPDATED    => time(),
                        BaseModel::STAMP_UPDATED_BY => Auth::id(),
                    ]);
                    break;
                }
            }
        }

        return ($objAuthGroup);
    }

    /**
     * @param SupportCollection $arrObjAuthPerms
     * @param User $objUser
     * @param AuthGroup $objAuthGroup
     * @param int $intValue
     * @return User
     * @throws Exception
     */
    public function attachUserPermissions(SupportCollection $arrObjAuthPerms, User $objUser, AuthGroup $objAuthGroup, int $intValue = 1): User {
        foreach ($arrObjAuthPerms as $objAuthPerm) {
            if ($this->checkIfExistsUserPermission($objAuthPerm, $objAuthGroup, $objUser) == Constant::NOT_EXIST) {
                $objUser->permissionsInGroup()->attach($objAuthPerm->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "group_id"                  => $objAuthGroup->group_id,
                    "group_uuid"                => $objAuthGroup->group_uuid,
                    "user_uuid"                 => $objUser->user_uuid,
                    "permission_uuid"           => $objAuthPerm->permission_uuid,
                    "permission_value"          => $intValue,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => Auth::id(),
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => Auth::id(),
                ]);
            }
        }

        return ($objUser);
    }

    /**
     * @param AuthPermissionModel $objAuthPerm
     * @param array $arrParams
     * @return AuthPermissionModel
     */
    public function update(AuthPermissionModel $objAuthPerm, array $arrParams): AuthPermissionModel {
        $arrPerm = [];

        if (isset($arrParams["name"])) {
            $arrPerm["permission_name"] = $arrParams["name"];
        }

        if (isset($arrParams["memo"])) {
            $arrPerm["permission_memo"] = $arrParams["memo"];
        }

        if (isset($arrParams["critical"])) {
            $arrPerm["flag_critical"] = $arrParams["critical"];
        }

        return ($this->permRepo->update($objAuthPerm, $arrPerm));
    }

    /**
     * @param int $intValue
     * @param AuthPermissionModel $objAuthPerm
     * @param AuthGroup $objAuthGroup
     * @return AuthGroup
     * @throws AuthException
     */
    public function updateGroupPermission(int $intValue, AuthPermissionModel $objAuthPerm, AuthGroup $objAuthGroup): AuthGroup {
        if ($intValue == 0 || $intValue == 1) {
            if ($this->checkIfExistsGroupPermission($objAuthPerm, $objAuthGroup) != Constant::NOT_EXIST) {
                $objAuthGroup->permissions()->updateExistingPivot($objAuthPerm->permission_id, [
                    "permission_value"          => $intValue,
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::UPDATED_AT       => Util::now(),
                    BaseModel::STAMP_UPDATED_BY => Auth::id(),
                ]);
            } else {
                throw AuthException::permissionNoExistsInGroup($objAuthGroup, $objAuthPerm);
            }
        } else {
            throw new Exception("Permission value must be 0 or 1", 417);
        }

        return ($objAuthGroup);
    }

    /**
     * @param array $arrPerms
     * @param User $objUser
     * @param Project $objProject
     * @return User
     * @throws Exception
     */
    public function updateProjectGroupPermissions(array $arrPerms, User $objUser, Project $objProject): User {
        $objAuthGroup = $this->groupRepo->findByProject($objProject);
        $this->deleteUserPermissionByGroup($objAuthGroup, $objUser);

        $permissionsNames = collect($arrPerms)->pluck("permission_name");
        $objProjectPermissions = Constant::project_level_permissions();
        $arrDisabledPermissions = Constant::user_level_permissions()->merge($objProjectPermissions)
            ->whereNotIn("permission_name", $permissionsNames)->transform(function ($item) {
                return [
                    "permission_name"  => $item->permission_name,
                    "permission_value" => false,
                ];
            })->values()->toArray();

        $arrPerms = array_merge($arrPerms, $arrDisabledPermissions);

        foreach ($arrPerms as $perm) {
            $objAuthPerm = $this->findByName($perm["permission_name"]);
            $intValue = $perm["permission_value"];
            $objUser = $this->updateUserPermission($intValue, $objAuthPerm, $objAuthGroup, $objUser);
        }

        return ($objUser);
    }

    /**
     * @param array $arrPerms
     * @param User $objUser
     * @param Project $objProject
     * @param App $objApp
     * @return User
     * @throws Exception
     */
    public function updateProjectAndAccountGroupPermissions(array $arrPerms, User $objUser, Project $objProject, App $objApp): User {
        /* Separate account-level permissions and other */
        [$accountLevelPerms, $projectPerms] = collect($arrPerms)->partition(function ($item) {
            return false !== stristr($item["permission_name"], "App.Soundblock.Account");
        })->toArray();

        /* Get groups and delete old permissions */
        $objAuthProjectGroup = $this->groupRepo->findByProject($objProject);
        $objAuthServiceGroup = $this->groupRepo->findByAccount($objProject->account);
        $this->deleteUserPermissionByGroup($objAuthProjectGroup, $objUser);
        $this->deleteUserPermissionByGroup($objAuthServiceGroup, $objUser);

        /* Attach user to groups */
        $this->groupRepo->addUserToGroup($objUser, $objAuthProjectGroup, $objApp);
        $this->groupRepo->addUserToGroup($objUser, $objAuthServiceGroup, $objApp);

        /* Create user project group permissions */
        foreach ($projectPerms as $projectPerm) {
            $objAuthProjectPerm = $this->findByName($projectPerm["permission_name"]);
            $intValue = $projectPerm["permission_value"];
            $objUser = $this->updateUserPermission($intValue, $objAuthProjectPerm, $objAuthProjectGroup, $objUser);
        }

        /* Create user service group permissions */
        foreach ($accountLevelPerms as $accountPerm) {
            $objAuthAccountPerm = $this->findByName($accountPerm["permission_name"]);
            $intValue = $accountPerm["permission_value"];
            $objUser = $this->updateUserPermission($intValue, $objAuthAccountPerm, $objAuthServiceGroup, $objUser);
        }

        return ($objUser);
    }

    /**
     * @param int $intValue
     * @param AuthPermissionModel $objAuthPerm
     * @param AuthGroup $objAuthGroup
     * @param User $objUser
     * @return User
     * @throws Exception
     */
    public function updateUserPermission(int $intValue, AuthPermissionModel $objAuthPerm, AuthGroup $objAuthGroup, User $objUser): User {
        if ($intValue == 0 || $intValue == 1) {
            $intFlag = $this->checkIfExistsUserPermission($objAuthPerm, $objAuthGroup, $objUser);

            if ($intFlag == Constant::EXIST) {
                $objUser->permissionsInGroup()->newPivotStatement()
                        ->where("core_auth_permissions_groups_users.group_id", $objAuthGroup->group_id)
                        ->where("core_auth_permissions_groups_users.permission_id", $objAuthPerm->permission_id)
                        ->where("core_auth_permissions_groups_users.user_id", $objUser->user_id)
                        ->update([
                            "permission_value"          => $intValue,
                            BaseModel::STAMP_UPDATED    => time(),
                            BaseModel::STAMP_UPDATED_BY => Auth::id(),
                            BaseModel::DELETED_AT       => null,
                            BaseModel::STAMP_DELETED    => null,
                            BaseModel::STAMP_DELETED_BY => null,
                        ]);
            } else if ($intFlag == Constant::NOT_EXIST) {
                $objUser->permissionsInGroup()->attach($objAuthPerm->permission_id, [
                    "row_uuid"                  => Util::uuid(),
                    "user_uuid"                 => $objUser->user_uuid,
                    "permission_uuid"           => $objAuthPerm->permission_uuid,
                    "group_id"                  => $objAuthGroup->group_id,
                    "group_uuid"                => $objAuthGroup->group_uuid,
                    "permission_value"          => $intValue,
                    BaseModel::STAMP_CREATED    => time(),
                    BaseModel::STAMP_CREATED_BY => Auth::id(),
                    BaseModel::STAMP_UPDATED    => time(),
                    BaseModel::STAMP_UPDATED_BY => Auth::id(),
                ]);

            }
        } else {
            throw new Exception("Permission value must be 0 or 1.", 417);
        }

        return ($objUser);
    }

    public function deleteUserPermissionByGroup($objGroup, $objUser) {
        $objUser->permissionsInGroup()
            ->newPivotStatement()
            ->where("core_auth_permissions_groups_users.group_id", $objGroup->group_id)
            ->where("core_auth_permissions_groups_users.user_id", $objUser->user_id)
            ->delete();

        return (true);
    }

    /**
     * @param $objGroup
     * @param $objUser
     * @return bool
     */
    public function detachUserPermissionByGroup($objGroup, $objUser) {
        $objUser->permissionsInGroup()
            ->where("core_auth_permissions_groups_users.group_id", $objGroup->group_id)
            ->where("core_auth_permissions_groups_users.user_id", $objUser->user_id)
            ->update([
                "core_auth_permissions_groups_users." . BaseModel::DELETED_AT       => Util::now(),
                "core_auth_permissions_groups_users." . BaseModel::STAMP_DELETED    => time(),
                "core_auth_permissions_groups_users." . BaseModel::STAMP_DELETED_BY => $objUser->user_id,
            ]);

        return (true);
    }

    /**
     * @param AuthPermissionModel $objAuthPerm
     * @param AuthGroup $objAuthGroup
     * @return AuthGroup
     */
    public function detachGroupPermission(AuthPermissionModel $objAuthPerm, AuthGroup $objAuthGroup): AuthGroup {
        $objAuthGroup->permissions()->updateExistingPivot($objAuthPerm->permission_id, [
            BaseModel::DELETED_AT       => Util::now(),
            BaseModel::STAMP_DELETED    => time(),
            BaseModel::STAMP_DELETED_BY => Auth::id(),
            BaseModel::UPDATED_AT       => Util::now(),
            BaseModel::STAMP_UPDATED    => time(),
            BaseModel::STAMP_UPDATED_BY => Auth::id(),
        ]);

        return ($objAuthGroup);
    }

    /**
     * @param User $objUser
     * @param AuthGroup $objAuthGroup
     * @param AuthPermissionModel $objAuthPerm
     * @return User
     * @throws Exception
     */
    public function deleteUserPermission(User $objUser, AuthGroup $objAuthGroup, AuthPermissionModel $objAuthPerm): User {
        if ($this->checkIfExistsUserPermission($objAuthPerm, $objAuthGroup, $objUser) !== Constant::NOT_EXISTS) {
            return ($this->detachUserPermission($objAuthPerm, $objUser, $objAuthGroup));
        } else {
            throw new  Exception();
        }
    }

    /**
     * @param AuthPermissionModel $objAuthPerm
     * @param User $objUser
     * @param AuthGroup $objAuthGroup
     * @return User
     */
    public function detachUserPermission(AuthPermissionModel $objAuthPerm, User $objUser, AuthGroup $objAuthGroup): User {
        $objUser->permissionsInGroup()->wherePivot("group_id", $objAuthGroup->group_id)
            ->updateExistingPivot($objAuthPerm->permission_id, [
                BaseModel::DELETED_AT       => Util::now(),
                BaseModel::STAMP_DELETED    => time(),
                BaseModel::STAMP_DELETED_BY => Auth::id(),
                BaseModel::UPDATED_AT       => Util::now(),
                BaseModel::STAMP_UPDATED    => time(),
                BaseModel::STAMP_UPDATED_BY => Auth::id(),
            ]);

        return ($objUser);
    }
}
