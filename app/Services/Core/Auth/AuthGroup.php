<?php

namespace App\Services\Core\Auth;

use Auth;
use Util;
use Client;
use Exception;
use Illuminate\Support\Collection;
use App\Models\{
    Core\Auth\AuthGroup as AuthGroupModel,
    Core\Auth\AuthPermission,
    BaseModel,
    Core\App,
    Core\Auth\AuthModel,
    Users\User,
    Soundblock\Projects\Project,
    Soundblock\Accounts\Account,
    Soundblock\Collections\Collection as SoundblockCollection
};
use App\Repositories\{Core\Auth\AuthGroup as AuthGroupRepository,
    Soundblock\Collection as CollectionRepository,
    Soundblock\Project as ProjectRepository,
    User\User as UserRepository
};

class AuthGroup {
    const EXISTS = 1;
    const NOT_EXISTS = 0;

    protected UserRepository $userRepo;
    protected AuthGroupRepository $groupRepo;
    protected ProjectRepository $projectRepo;
    protected CollectionRepository $colRepo;

    /**
     * AuthGroupService constructor.
     * @param AuthGroupRepository $groupRepo
     * @param UserRepository $userRepo
     * @param ProjectRepository $projectRepo
     * @param CollectionRepository $colRepo
     */
    public function __construct(AuthGroupRepository $groupRepo, UserRepository $userRepo, ProjectRepository $projectRepo,
                                CollectionRepository $colRepo) {
        $this->colRepo = $colRepo;
        $this->userRepo = $userRepo;
        $this->groupRepo = $groupRepo;
        $this->projectRepo = $projectRepo;
    }

    /**
     * @param $id
     * @param bool $bnFailure
     * @return AuthGroupModel
     * @throws Exception
     */
    public function find($id, bool $bnFailure = true): AuthGroupModel {
        return ($this->groupRepo->find($id, $bnFailure));
    }

    /**
     * @param array $arrParams
     * @param int $perPage
     * @return mixed
     */
    public function findAll(array $arrParams, $perPage = 10) {
        [$objAuthGroups, $availableMetaData] = $this->groupRepo->findAll($arrParams, $perPage);

        return ([$objAuthGroups, $availableMetaData]);
    }

    /**
     * @param string $name
     * @return AuthGroupModel
     */
    public function findByName(string $name) {
        return ($this->groupRepo->findByName($name));
    }

    /**
     * @param string $userUuid
     * @param int $perPage
     * @param bool $paginate
     * @return mixed
     */
    public function findByUser(string $userUuid, int $perPage = 10, bool $paginate = true) {
        return ($this->groupRepo->findByUser($userUuid, $perPage, $paginate));
    }

    /**
     * @param AuthPermission $objAuthPerm
     * @param int $perPage
     * @return mixed
     */
    public function findAllByPermission(AuthPermission $objAuthPerm, $perPage = 10) {
        return ($this->groupRepo->findAllByPermission($objAuthPerm, $perPage));
    }

    /**
     * @param mixed $collection
     * @return AuthGroupModel
     * @throws Exception
     */
    public function findByCollection($collection): AuthGroupModel {
        if ($collection instanceof SoundblockCollection) {
            $objCol = $collection;
        } else if (Util::is_uuid($collection) || is_int($collection)) {
            $objCol = $this->colRepo->find($collection, true);
        } else {
            throw new Exception();
        }

        return ($this->findByProject($objCol->project));
    }

    /**
     * @param mixed $project
     * @return AuthGroupModel
     * @throws Exception
     */
    public function findByProject($project): AuthGroupModel {
        if ($project instanceof Project) {
            $objProject = $project;
        } else if (Util::is_uuid($project) || is_int($project)) {
            $objProject = $this->projectRepo->find($project, true);
        } else {
            throw new Exception("Project is invalid parameter.");
        }

        return ($this->groupRepo->findByProject($objProject));
    }

    /**
     * @param Account $objAccount
     * @return AuthGroupModel
     */
    public function findByAccount(Account $objAccount) {
        return ($this->groupRepo->findByAccount($objAccount));
    }

    /**
     * @param array $where
     * @param string $field
     * @return mixed
     * @throws Exception
     */
    public function findAllWhere(array $where, string $field = "uuid") {
        return $this->groupRepo->findAllWhere($where, $field);
    }

    public function search(array $arrParams) {
        return $this->groupRepo->search($arrParams);
    }

    /**
     * @param User $objUser
     * @param AuthGroupModel $objAuthGroup
     * @return int
     */
    public function checkIfUserExists(User $objUser, AuthGroupModel $objAuthGroup) {
        return ($this->groupRepo->checkIfUserExists($objUser, $objAuthGroup));
    }

    /**
     * @param $arrParams
     * @param bool $blnFlagCritical
     * @param App|null $objApp
     * @param AuthModel|null $objAuth
     * @return AuthGroup
     */
    public function createGroup($arrParams, $blnFlagCritical = false, App $objApp = null, AuthModel $objAuth = null) {
        if (is_null($objApp)) {
            $objApp = Client::app();
        }
        if (is_null($objAuth)) {
            $objAuth = Client::auth();
        }

        $arrUsers = collect();
        if (isset($arrParams["users"]) && $arrParams["users"] instanceof User) {
            $arrUsers->push($arrParams["user"]);
        } else {
            $arrUsers->push(Auth::user());
        }

        if ($blnFlagCritical) {
            // Will be able to check if group_type is project or service.
            $arrParams["group_name"] = Util::makeGroupName($objAuth, $arrParams["group_type"], $arrParams["object"]);
            $arrParams["group_memo"] = Util::makeGroupMemo($objAuth, $arrParams["group_type"], $arrParams["object"]);

            $objAuthGroup = $this->create($arrParams, $blnFlagCritical);
            $objAuthGroup = $this->addUsersToGroup($arrUsers, $objAuthGroup, $objApp);
        } else {
            $objAuthGroup = $this->create($arrParams, $blnFlagCritical);
            $objAuthGroup = $this->addUsersToGroup($arrUsers, $objAuthGroup, $objApp);
        }

        return ($objAuthGroup);
    }

    /**
     * @param array $arrParams
     * @param bool $bnFlagCritical
     * @return AuthGroupModel
     */
    public function create(array $arrParams, $bnFlagCritical = false): AuthGroupModel {
        $arrGroup = [];
        $objAuth = Client::auth();

        $arrGroup["auth_id"] = $objAuth->auth_id;
        $arrGroup["auth_uuid"] = $objAuth->auth_uuid;
        $arrGroup["group_name"] = $arrParams["group_name"];
        $arrGroup["group_memo"] = $arrParams["group_memo"];
        $arrGroup["flag_critical"] = $bnFlagCritical;

        return ($this->groupRepo->create($arrGroup));
    }

    /**
     * @param Collection $arrObjUsers
     * @param AuthGroupModel $objAuthGroup
     * @param App $objApp
     * @return Object
     */
    public function addUsersToGroup(Collection $arrObjUsers, AuthGroupModel $objAuthGroup, App $objApp) {
        foreach ($arrObjUsers as $objUser) {
            $objAuthGroup = $this->addUserToGroup($objUser, $objAuthGroup, $objApp);
        }

        return ($objAuthGroup);
    }

    /**
     * @param User $objUser
     * @param AuthGroupModel $objAuthGroup
     * @param App $objApp
     * @return AuthGroupModel
     */
    public function addUserToGroup(User $objUser, AuthGroupModel $objAuthGroup, App $objApp) {
        return ($this->groupRepo->addUserToGroup($objUser, $objAuthGroup, $objApp));
    }

    /**
     * @param $arrParams
     * @return AuthGroupModel
     * @throws Exception
     */
    public function addUsers($arrParams) {
        $objApp = Client::app();
        $objAuthGroup = $this->find($arrParams["group"]);
        $arrObjUsers = $this->userRepo->findAllWhere($arrParams["users"]);

        return ($this->addUsersToGroup($arrObjUsers, $objAuthGroup, $objApp));
    }

    public function remove($arrAuthGroup) {
        $objAuthGroup = $this->find($arrAuthGroup["group"]);

        if (!$objAuthGroup->flag_critical && $objAuthGroup->delete()) {
            $objAuthGroup->users()->newPivotStatement()
                         ->where("group_id", $objAuthGroup->group_id)
                         ->update([
                             BaseModel::DELETED_AT       => Util::now(),
                             BaseModel::STAMP_DELETED    => time(),
                             BaseModel::STAMP_DELETED_BY => Auth::id(),
                         ]);

            $objAuthGroup->pusers()->newPivotStatement()
                         ->where("group_id", $objAuthGroup->group_id)
                         ->update([
                             BaseModel::DELETED_AT       => Util::now(),
                             BaseModel::STAMP_DELETED    => time(),
                             BaseModel::STAMP_DELETED_BY => Auth::id(),
                         ]);
            $objAuthGroup->permissions()->newPivotStatement()
                         ->where("group_id", $objAuthGroup->group_id)
                         ->update([
                             BaseModel::DELETED_AT       => Util::now(),
                             BaseModel::STAMP_DELETED    => time(),
                             BaseModel::STAMP_DELETED_BY => Auth::id(),
                         ]);

            return (true);
        } else
            return (false);

    }

    /**
     * @param array $arrParams
     * @return AuthGroupModel
     * @throws Exception
     */
    public function removeUsersFromGroup($arrParams) {
        $objAuthGroup = $this->find($arrParams["group"]);
        $arrObjUsers = $this->userRepo->findAllWhere($arrParams["users"]);

        return ($this->detachUsersFromGroup($arrObjUsers, $objAuthGroup));
    }

    /**
     * @param $arrObjUsers
     * @param $objAuthGroup
     * @return AuthGroupModel
     */

    public function detachUsersFromGroup(Collection $arrObjUsers, AuthGroupModel $objAuthGroup) {
        return ($this->groupRepo->detachUsersFromGroup($arrObjUsers, $objAuthGroup));
    }
}
