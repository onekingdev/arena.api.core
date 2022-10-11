<?php

namespace App\Http\Controllers\Core\Auth;

use Auth;
use Exception;
use App\Models\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};
use App\Exceptions\Core\Auth\AuthException;
use App\Http\Requests\{Office\Auth\AuthGroup\AutoComplete,
    Auth\Access\AddUser,
    Auth\Access\DeleteGroup,
    Auth\Access\DeleteUsersInGroup,
    Auth\Access\CreateGroup,
    Office\Auth\AuthGroup\GetAuthGroup};
use App\Http\Transformers\{User\User as UserTransformer, Auth\AuthGroup as AuthGroupTransformer};
use App\Services\{User as UserService, Core\Auth\AuthGroup as AuthGroupService, Core\Auth\AuthPermission};

/**
 * @group Core Auth
 *
 */
class AuthGroup extends Controller
{
    /** @var AuthGroupService */
    protected AuthGroupService $authGroupService;
    /** @var AuthPermission */
    protected AuthPermission $authPermService;
    /** @var UserService */
    private UserService $userService;

    /**
     * AuthGroup constructor.
     * @param AuthGroupService $authGroupService
     * @param UserService $userService
     * @param AuthPermission $authPermService
     */
    public function __construct(AuthGroupService $authGroupService, UserService $userService,
                                AuthPermission $authPermService) {
        $this->authGroupService = $authGroupService;
        $this->authPermService = $authPermService;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return object
     */
    public function index(Request $request) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$arrAuthGroups, $availableMetaData] = $this->authGroupService->findAll($request->all(), $request->input("per_page", 10));

        return ($this->apiReply($arrAuthGroups, "", Response::HTTP_OK, $availableMetaData));
    }

    /**
     * @param AutoComplete $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(AutoComplete $request) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrGroups = $this->authGroupService->search($request->all());

        return response()->json($arrGroups);
    }

    /**
     * @param GetAuthGroup $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function show(GetAuthGroup $objRequest) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->find($objRequest->group);

        return ($this->item($objAuthGroup, new AuthGroupTransformer(["permissions"])));
    }

    /**
     * @param string $user
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthException
     */
    public function getUserGroups(string $user) {
        /**  @var User $objAuth*/
        $objAuth = Auth::user();
        if (!is_authorized($objAuth, "Superuser", "Superuser", "office")) {
            $objForbiddenPerm = $this->authPermService->findByName("App.Office.Access");

            throw AuthException::userForbidden($objAuth, $objForbiddenPerm);
        }

        $objUser = $this->userService->find($user);

        return ($this->item($objUser, new UserTransformer(["groups"])));
    }

    /**
     * @param CreateGroup $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function store(CreateGroup $objRequest) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->createGroup($objRequest->all());

        return ($this->item($objAuthGroup, new AuthGroupTransformer()));
    }

    /**
     * @param AddUser $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function addUsers(AddUser $objRequest) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->addUsers($objRequest->all());

        return ($this->item($objAuthGroup, new AuthGroupTransformer(["users"])));
    }

    /**
     * @param DeleteGroup $objRequest
     * @return object
     */
    public function deleteGroup(DeleteGroup $objRequest) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if ($this->authGroupService->remove($objRequest->all())) {
            return ($this->apiReply(null, "Successfully group deleted."));
        } else {
            return ($this->apiReject("Deleted failure"));
        }
    }

    /**
     * @param DeleteUsersInGroup $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function deleteUsersInGroup(DeleteUsersInGroup $objRequest) {
        if (!is_authorized(Auth::user(), "Superuser", "Superuser", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objAuthGroup = $this->authGroupService->removeUsersFromGroup($objRequest->all());

        return ($this->item($objAuthGroup, new AuthGroupTransformer(["users", "permissions"])));
    }
}
