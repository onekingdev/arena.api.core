<?php

namespace App\Http\Controllers\Core\Auth;

use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Services\User;
use App\Http\Resources\Common\UserCollection;
use App\Http\Requests\Auth\Access\{
    GetPermissions,
    AddPermissionsToGroup,
    AddPermissionsToUser,
    DeletePermissionsInGroup
};
use App\Http\Requests\Office\Auth\AuthPermission\{
    CreateAuthPermissiion,
    DeletePermissionInUser,
    GetAuthPermission,
    UpdateAuthPermissionInGroup,
    UpdateAuthPermissionInUser,
    UpdatePermission
};
use App\Services\Core\Auth\{AuthGroup as AuthGroupService, AuthPermission as AuthPermissionService};

/**
 * @group Core Auth
 *
 */
class AuthPermission extends Controller {

    /** @var AuthPermissionService */
    protected AuthPermissionService $authPermService;
    /** @var User */
    protected User $userService;
    /** @var AuthGroupService */
    private AuthGroupService $authGroupService;

    /**
     * AuthPermission constructor.
     * @param AuthPermissionService $authPermService
     * @param User $userService
     * @param AuthGroupService $authGroupService
     */
    public function __construct(AuthPermissionService $authPermService, User $userService, AuthGroupService $authGroupService) {
        $this->userService = $userService;
        $this->authPermService = $authPermService;
        $this->authGroupService = $authGroupService;
    }

    /**
     * @return object
     */
    public function index() {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrAuthPerms = $this->authPermService->findAll();

        return ($this->apiReply($arrAuthPerms, "", Response::HTTP_OK));
    }

    /**
     * @param GetAuthPermission $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function show(GetAuthPermission $objRequest) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthPerm = $this->authPermService->find($objRequest->permission);

        return ($this->apiReply($objAuthPerm));
    }

    /**
     * @param string $permission
     * @return UserCollection
     * @throws Exception
     */
    public function getPermissionUsers(string $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthPerm = $this->authPermService->find($permission);

        return (new UserCollection($this->userService->findAllByPermission($objAuthPerm)));
    }

    /**
     * @param GetAuthPermission $objRequest
     * @param string $permission
     * @return object
     * @throws Exception
     */
    public function getPermissionGroups(GetAuthPermission $objRequest, string $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $perPage = $objRequest->input("per_page", 10);
        $objAuthPerm = $this->authPermService->find($permission);
        $objPermGroups = $this->authGroupService->findAllByPermission($objAuthPerm, $perPage);

        return ($this->apiReply($objPermGroups, "", Response::HTTP_OK));
    }

    /**
     * @param GetPermissions $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function getPermissionsInGroup(GetPermissions $objRequest) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->find($objRequest->group);

        return ($this->apiReply($objAuthGroup->permissions));
    }

    /**
     * @param CreateAuthPermissiion $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function store(CreateAuthPermissiion $objRequest) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthPerm = $this->authPermService->create($objRequest->all());

        return ($this->apiReply($objAuthPerm));
    }

    /**
     * @param UpdatePermission $objRequest
     * @param $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function updatePermission(UpdatePermission $objRequest, $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthPerm = $this->authPermService->find($permission, true);
        $objAuthPerm = $this->authPermService->update($objAuthPerm, $objRequest->all());

        return ($this->apiReply($objAuthPerm));
    }

    /**
     * @param AddPermissionsToUser $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function addPermissionsToUser(AddPermissionsToUser $objRequest) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objUser = $this->userService->find($objRequest->input("user"), true);
        $objAuthGroup = $this->authGroupService->find($objRequest->input("group"), true);
        $arrAuthPerms = $this->authPermService->findAllWhere($objRequest->input("permissions"));

        $objUser = $this->authPermService->attachUserPermissions($arrAuthPerms, $objUser, $objAuthGroup);

        return ($this->apiReply($objUser->load("permissionsInGroup")));
    }

    /**
     * @param UpdateAuthPermissionInUser $objRequest
     * @param string $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function updateUserPermission(UpdateAuthPermissionInUser $objRequest, string $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objUser = $this->userService->find($objRequest->input("user"), true);
        $objAuthPerm = $this->authPermService->find($permission, true);
        $objAuthGroup = $this->authGroupService->find($objRequest->input("group"), true);

        $objUser = $this->authPermService->updateUserPermission($objRequest->input("permission_value"), $objAuthPerm, $objAuthGroup, $objUser);

        return ($this->apiReply($objUser->with("groupsWithPermissions")));
    }

    /**
     * @param AddPermissionsToGroup $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function addPermissionsToGroup(AddPermissionsToGroup $objRequest) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->find($objRequest->input("group"), true);
        $arrObjPerms = $this->authPermService->findAllWhere($objRequest->input("permissions"));

        $objAuthGroup = $this->authPermService->attachGroupPermissions($arrObjPerms, $objAuthGroup);

        return ($this->apiReply($objAuthGroup->load("permissions")));
    }

    /**
     * @param UpdateAuthPermissionInGroup $objRequest
     * @param string $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \App\Exceptions\Core\Auth\AuthException
     * @throws Exception
     */
    public function updatePermissionInGroup(UpdateAuthPermissionInGroup $objRequest, string $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->find($objRequest->input("group"), true);
        $objAuthPerm = $this->authPermService->find($permission, true);

        $objAuthGroup = $this->authPermService->updateGroupPermission($objRequest->input("permission_value"), $objAuthPerm, $objAuthGroup);

        return ($this->apiReply($objAuthGroup->load("permissions")));
    }

    /**
     * @param DeletePermissionInUser $objRequest
     * @param string $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function deleteUserPermission(DeletePermissionInUser $objRequest, string $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objUser = $this->userService->find($objRequest->input("user"), true);
        $objAuthPerm = $this->authPermService->find($permission, true);
        $objAuthGroup = $this->authGroupService->find($objRequest->input("group"), true);

        $objUser = $this->authPermService->deleteUserPermission($objUser, $objAuthPerm, $objAuthGroup);

        return ($this->apiReply($objUser->load("groupsWithPermissions")));
    }

    /**
     * @param DeletePermissionsInGroup $objRequest
     * @param string $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function deletePermissionInGroup(DeletePermissionsInGroup $objRequest, string $permission) {
        if (!is_authorized(AuthFacade::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthPerm = $this->authPermService->find($permission, true);
        $objAuthGroup = $this->authGroupService->find($objRequest->input("group"), true);

        $objAuthGroup = $this->authPermService->detachGroupPermission($objAuthPerm, $objAuthGroup);

        return ($this->apiReply($objAuthGroup->load("permissions")));
    }
}
