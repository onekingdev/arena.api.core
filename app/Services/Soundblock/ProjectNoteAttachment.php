<?php

namespace App\Services\Soundblock;

use Util;
use App\Repositories\Soundblock\ProjectNoteAttachment as ProjectNoteAttachmentRepository;
use App\Models\Soundblock\{Projects\ProjectNote, Projects\ProjectNoteAttachment as ProjectNoteAttachmentModel};

class ProjectNoteAttachment {

    protected ProjectNoteAttachmentRepository $attachRepo;

    public function __construct(ProjectNoteAttachmentRepository $attachRepo) {
        $this->attachRepo = $attachRepo;
    }

    /**
     * @param ProjectNote $objNote
     * @param array $arrParams
     * @return ProjectNoteAttachmentModel
     * @throws \Exception
     */
    public function create(ProjectNote $objNote, array $arrParams): ProjectNoteAttachmentModel {
        $objAttach = new ProjectNoteAttachmentModel;

        $arrAttach = [];
        $arrAttach["row_uuid"]       = Util::uuid();
        $arrAttach["note_id"]        = $objNote->note_id;
        $arrAttach["note_uuid"]      = $objNote->note_uuid;
        $arrAttach["attachment_url"] = $arrParams["attachment_url"];

        $objAttach->fill($arrAttach);
        $objAttach->save();

        return ($objAttach);
    }

    /**
     * @param ProjectNoteAttachmentModel $objAttach
     * @param array $arrParams
     * @return ProjectNoteAttachmentModel
     */
    public function update(ProjectNoteAttachmentModel $objAttach, array $arrParams): ProjectNoteAttachmentModel {
        $arrAttach = [];

        if (isset($arrParams["attachment_url"])) {
            $arrAttach["attachment_url"] = $arrParams["attachment_url"];
        }

        return ($this->attachRepo->update($objAttach, $arrAttach));
    }
}
