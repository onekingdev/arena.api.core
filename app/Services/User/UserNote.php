<?php

namespace App\Services\User;

use Auth;
use Util;
use App\Services\Common\Zip;
use App\Events\User\{DeleteUserNote, UserNoteAttach};
use App\Repositories\User\{UserNote as UserNoteRepository};
use App\Models\{Users\User, Users\UserNote as UserNoteModel};
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserNote {
    /** @var UserNoteRepository */
    protected UserNoteRepository $noteRepo;
    /** @var Zip */
    protected Zip $zipService;

    /**
     * @param UserNoteRepository $noteRepo
     * @param Zip $zipService
     * @return void
     */
    public function __construct(UserNoteRepository $noteRepo, Zip $zipService) {
        $this->noteRepo = $noteRepo;
        $this->zipService = $zipService;
    }

    public function find($note, bool $bnFailure = true) {
        return ($this->noteRepo->find($note, $bnFailure));
    }

    public function findByUsers(User $objUser, $perPage = 10) {
        return ($objUser->notes()->paginate($perPage));
    }

    public function userHasNotes(User $objUser, UserNoteModel $objNote) {
        return ($objUser->notes()->where("note_id", $objNote->note_id)->exists());
    }

    public function create(array $arrParams, User $objUser = null) {
        $arrNote = [];
        if (!$objUser)
            $objUser = Auth::user();

        $arrNote["user_id"] = $objUser->user_id;
        $arrNote["user_uuid"] = $objUser->user_uuid;
        $arrNote["user_notes"] = $arrParams["user_notes"];

        $objNote = $this->noteRepo->create($arrNote);
        if (isset($arrParams["files"])) {
            $arrUrls = $this->upload($objNote->user, $arrParams["files"]);

            event(new UserNoteAttach($objNote, $arrUrls));
        }

        return ($objNote);
    }

    public function upload(User $objUser, $arrFiles) {
        $arrUrls = [];
        foreach ($arrFiles as $file) {
            $userNotePath = Util::user_note_path($objUser);

            $url = $this->zipService->upload($userNotePath, $file);
            array_push($arrUrls, $url);
        }

        return ($arrUrls);
    }

    public function delete($note, User $objUser) {
        $objNote = $this->find($note);
        if (!$this->userHasNotes($objUser, $objNote)) {
            throw new BadRequestHttpException("User has n't this notes.");
        }
        event(new DeleteUserNote($objNote));

        return ($this->noteRepo->destroy($note));
    }
}
