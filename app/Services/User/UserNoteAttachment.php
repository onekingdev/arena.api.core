<?php

namespace App\Services\User;

use Util;
use App\Models\{Users\UserNote, Users\UserNoteAttachment as UserNoteAttachmentModel};

class UserNoteAttachment {
    public function create(array $arrParams) {
        $objAttach = new UserNoteAttachmentModel();
        $objAttach->row_uuid = Util::uuid();

        return ($this->update($objAttach, $arrParams));
    }

    public function update(UserNoteAttachmentModel $objAttach, array $arrParams) {
        if (isset($arrParams["note"]) && $arrParams["note"] instanceof UserNote) {
            $objNote = $arrParams["note"];
            $objAttach->note_id = $objNote->note_id;
            $objAttach->note_uuid = $objNote->note_uuid;
        }

        if (isset($arrParams["attachment_url"])) {
            $objAttach->attachment_url = $arrParams["attachment_url"];
        }

        $objAttach->save();

        return ($objAttach);
    }

    public function delete(UserNote $objNote) {
        foreach ($objNote->attachments as $objAttach) {
            $objAttach->delete();
        }
    }
}
