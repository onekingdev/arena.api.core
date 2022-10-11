<?php

namespace App\Services\Soundblock;

use Util;
use App\Models\Soundblock\{Accounts\AccountNote, Accounts\AccountNoteAttachment};
use App\Repositories\Common\AccountNoteAttachment as AccountNoteAttachmentRepository;

class AccountNoteAttach {
    protected AccountNoteAttachmentRepository $attachRepo;

    public function __construct(AccountNoteAttachmentRepository $attachRepo) {
        $this->attachRepo = $attachRepo;
    }

    /**
     * @param AccountNote $objNote
     * @param array $arrParams
     * @return AccountNoteAttachment
     * @throws \Exception
     */
    public function create(AccountNote $objNote, array $arrParams) {
        $arrAttach = [];

        $arrAttach["row_uuid"] = Util::uuid();
        $arrAttach["note_id"] = $objNote->note_id;
        $arrAttach["note_uuid"] = $objNote->note_uuid;
        $arrAttach["attachment_url"] = $arrParams["attachment_url"];

        $obj = new AccountNoteAttachment();
        $obj->fill($arrAttach);
        $obj->save();

        return ($obj);
    }

    /**
     * @param AccountNoteAttachment $objAttach
     * @param array $arrParams
     * @return mixed
     */
    public function update(AccountNoteAttachment $objAttach, array $arrParams) {
        $arrAttach = [];
        if (isset($arrParams["attachment_url"])) {
            $arrAttach["attachment_url"] = $arrParams["attachment_url"];
        }

        return ($this->attachRepo->update($objAttach, $arrAttach));
    }
}
