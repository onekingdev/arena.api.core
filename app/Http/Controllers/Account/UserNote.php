<?php

namespace App\Http\Controllers\Account;

use Auth;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Transformers\User\UserNote as UserNoteTransformer;
use App\Http\Requests\User\{CreateUserNote, DeleteUserNote, GetUserNotes};
use App\Services\{Auth as AuthService, User, User\UserNote as UserNoteService};

/**
 * @group Account
 *
 */
class UserNote extends Controller {
    /** @var AuthService */
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    /**
     * @param GetUserNotes $objRequest
     * @param UserNoteService $noteService ,
     * @param User $userService
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function index(GetUserNotes $objRequest, UserNoteService $noteService, User $userService) {
        $objUser = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office") ?
                        $userService->find($objRequest->user) : Auth::user();

        $arrNotes = $noteService->findByUsers($objUser);
        return ($this->paginator($arrNotes, new UserNoteTransformer(["attachments"])));
    }

    /**
     * @param CreateUserNote $objRequest
     * @param UserNoteService $noteService
     * @param User $userService
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function store(CreateUserNote $objRequest, UserNoteService $noteService, User $userService) {
        $objUser = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office") ?
            $userService->find($objRequest->user) : Auth::user();

        $objNote = $noteService->create($objRequest->all(), $objUser);

        return ($this->item($objNote, new UserNoteTransformer(["attachments"])));
    }

    /**
     * @param DeleteUserNote $objRequest
     * @param UserNoteService $noteService
     * @param User $userService
     * @return \Illuminate\Http\Response|object
     * @throws Exception
     */
    public function delete(DeleteUserNote $objRequest, UserNoteService $noteService, User $userService) {
        $objUser = is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office") ?
            $userService->find($objRequest->user) : Auth::user();

        $noteService->delete($objRequest->note, $objUser);

        return ($this->apiReply());
    }
}
