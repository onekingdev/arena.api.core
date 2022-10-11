<?php

namespace App\Http\Controllers\Core;

use Auth;
use Exception;
use App\Traits\Cacheable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Facades\Cache\AppCache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Services\User as UserService;
use App\Http\Requests\Core\UserAutocomplete;
use App\Repositories\User\User as UserRepository;
use App\Http\Transformers\User\{User as UserTransformer, Avatar, Avatars};
use App\Http\Requests\Office\{User\AutoComplete, User\User as UserRequest};
use App\Http\Requests\User\{
    Update,
    Security,
    UserAlias,
    UserAvatar,
    CreateAccount
};

/**
 * @group Core
 *
 */
class User extends Controller {
    use Cacheable;

    /** @var UserService */
    private UserService $userService;
    /** @var UserRepository */
    private UserRepository $userRepository;

    /**
     * @param UserService $userService
     * @param UserRepository $userRepository
     */
    public function __construct(UserService $userService, UserRepository $userRepository) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserRequest $objRequest
     * @return object
     */
    public function indexForOffice(UserRequest $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        if ($objRequest->user) {
            $user = $this->userService->find($objRequest->user);
            $user = $this->userService->getPrimary($user);

            return ($this->apiReply($user, "", 200));
        } else {
            $objUsers = $this->userRepository->findAllWithFilters($objRequest->except(["per_page", "user"]), $objRequest->input("per_page", 10));

            return ($this->apiReply($objUsers, "", Response::HTTP_OK));
        }
    }

    /**
     * @param int $intUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $intUser) {
        $objUser = $this->userService->find($intUser);

        return ($this->item($objUser, new UserTransformer()));
    }

    /**
     * @param AutoComplete $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function search(AutoComplete $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $arrRelations = [];
        $objUser = $this->userService->search($objRequest->all());

        if ($objRequest->has("select_relations")) {
            $arrRelations = explode(",", $objRequest->input("select_relations"));
        }

        return ($this->collection($objUser, new UserTransformer($arrRelations, false, null, $objRequest->all())));
    }

    /**
     * @param UserAutocomplete $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function autocomplete(UserAutocomplete $objRequest){
        if (
            is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office") ||
            is_authorized(Auth::user(), "App.Ux.Admin", "App.Ux.Default", "ux")
        ) {
            $result = $this->userService->findByName($objRequest->input("user_name"));

            if ($result) {
                return ($this->apiReply($result, "", 200));
            }

            return ($this->apiReject(null, "Users not found.", 400));
        } else {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @param string $strUserUuid
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getUserAvatarByUuid(string $strUserUuid) {
        [$isCached, $strAvatarUrl] = $this->userService->getAvatarByUuid($strUserUuid);

        if ($isCached) {
            return response()->json(AppCache::getCache());
        }

        return ($this->sendCacheResponse(response()->json(["user_avatar" => $strAvatarUrl])));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function getUsersAvatars(Request $request) {
        $arrUsersUuids = $request->input("uuids");
        $objUsers = $this->userRepository->findAllWhere($arrUsersUuids);

        return ($this->collection($objUsers, new Avatars));
    }

    /**
     * @param Request $request
     * @return object
     * @throws Exception
     */
    public function store(Request $request) {
        $objUser = $this->userService->create($request->all());

        return ($this->apiReply($objUser));
    }

    /**
     * @param CreateAccount $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function createAccount(CreateAccount $request) {
        try {
            $user = $this->userService->createAccount($request->all());

            return ($this->item($user, new UserTransformer));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Update $objRequest
     * @param null $user
     * @return \Illuminate\Http\Response
     * @transformer \App\Http\Transformers\UserTransformer
     * @transformerModel \App\Models\User
     */
    public function update(Update $objRequest, $user = null) {
        if ($objRequest->has("user")) {
            $objUser = $this->userService->find($objRequest->input("user"), true);
        } else if (isset($user)) {
            $objUser = $this->userService->find($user, true);
        } else {
            $objUser = Auth::user();
        }

        $objUser = $this->userService->update($objUser, $objRequest->all());

        return ($this->apiReply($objUser));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $intUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($intUser) {
        $arrUser = $this->userService->find($intUser);
        $this->userService->delete($arrUser);
        return ($this->apiReply());
    }


    /**
     * @param UserAlias $objRequest
     * @param $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function addAlias(UserAlias $objRequest, $user) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objUser = $this->userService->find($user);
        $objAlias = $this->userService->addAlias($objUser, $objRequest->input("alias"));

        return ($this->apiReply($objAlias, "User alias updated successfully.", 200));
    }

    /**
     * User Security
     *
     * @param Security $objRequest
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function security(Security $objRequest, $user) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objUser = $this->userService->find($user);

        if ($objRequest->has("password")) {
            if (!Hash::check($objRequest->input("old_password"), $objUser->getAuthPassword())) {
                throw new \Exception("Old password is not valid", 400);
            }
            $objUser = $this->userService->update($objUser, ["user_password" => $objRequest->input("password")]);
        }

        if ($objRequest->has("g2fa")) {
            $this->userService->toggle2FA($objUser, $objRequest->input("g2fa"));
        }

        return ($this->item($objUser, new UserTransformer(["emails", "aliases"], false)));
    }

    /**
     * @param UserAvatar $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function createAvatar(UserAvatar $objRequest) {
        $user = Auth::user();
        $fileName = $this->userService->addAvatar($user, $objRequest->file("file"));
        $objUser = $this->userRepository->updateUserAvatar($user, $fileName);

        return ($this->item($objUser, new Avatar()));
    }

    /**
     * @param string $user
     * @param string $alias
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function deleteAlias(string $user, string $alias){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        $objUser = $this->userService->find($user);
        $boolResult = $this->userService->deleteAlias($objUser, $alias);

        if ($boolResult) {
            return ($this->apiReply(null, "Alias delete successfully.", 200));
        }

        return ($this->apiReject(null, "Something went wrong.", 400));
    }
}
