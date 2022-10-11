<?php

namespace App\Services\Soundblock;

use Util;
use Auth;
use App\Services\Common\Zip;
use App\Events\Soundblock\AccountNoteAttach;
use App\Models\Soundblock\{Accounts\Account, Accounts\AccountNote as AccountNoteModel};
use App\Repositories\{Common\AccountNote as AccountNoteRepository, Common\Account as AccountRepository, User\User};

class AccountNote {

    protected AccountNoteRepository $noteRepo;
    protected AccountRepository $accountRepo;
    protected User $userRepo;
    protected Zip $zipService;

    public function __construct(AccountNoteRepository $noteRepo, AccountRepository $accountRepo, User $userRepo, Zip $zipService) {
        $this->noteRepo    = $noteRepo;
        $this->userRepo    = $userRepo;
        $this->zipService  = $zipService;
        $this->accountRepo = $accountRepo;
    }

    /**
     * @param $note
     * @param bool $bnFailure
     * @return mixed
     * @throws \Exception
     */
    public function find($note, bool $bnFailure = true) {
        return ($this->noteRepo->find($note, $bnFailure));
    }

    /**
     * @param array $arrFilters
     * @param int $perPage
     * @return mixed
     * @throws \Exception
     */
    public function findAllByAccount(array $arrFilters, $perPage = 10) {
        [$objNotes, $availableMetaData] = $this->noteRepo->findAll($arrFilters, $perPage);

        return ([$objNotes, $availableMetaData]);
    }

    /**
     * @param array $arrParams
     * @return AccountNoteModel
     * @throws \Exception
     */
    public function create(array $arrParams): AccountNoteModel {
        $arrNotes = [];
        $objAccount = $this->accountRepo->find($arrParams["account"]);

        if (isset($arrParams["user"])) {
            $objUser = $this->userRepo->find($arrParams["user"], true);
        } else {
            $objUser = Auth::user();
        }

        $arrNotes["user_id"] = $objUser->user_id;
        $arrNotes["user_uuid"] = $objUser->user_uuid;
        $arrNotes["account_id"] = $objAccount->account_id;
        $arrNotes["account_uuid"] = $objAccount->account_uuid;
        $arrNotes["account_notes"] = $arrParams["account_notes"];

        $objNote = $this->noteRepo->create($arrNotes);

        if (isset($arrParams["files"])) {
            $urls = $this->upload($objAccount, $arrParams["files"]);

            event(new AccountNoteAttach($objNote, $urls));
        }

        return ($objNote);
    }

    /**
     * @param Account $objAccount
     * @param array $arrFiles
     * @return array
     */
    public function upload(Account $objAccount, array $arrFiles) {
        $urls = [];

        foreach ($arrFiles as $file) {
            $notePath = Util::account_note_path($objAccount);
            array_push($urls, $this->zipService->saveFile($notePath, $file));
        }

        return ($urls);
    }

    /**
     * @param AccountNoteModel $objNote
     * @param array $arrParams
     * @return AccountNoteModel
     */
    public function update(AccountNoteModel $objNote, array $arrParams): AccountNoteModel {
        $arrNotes = [];

        if (isset($arrParams["account_notes"])) {
            $arrNotes["account_notes"] = $arrParams["account_notes"];
        }

        return ($this->noteRepo->update($objNote, $arrNotes));
    }
}
