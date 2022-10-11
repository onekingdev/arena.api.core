<?php

namespace App\Listeners\Soundblock;

use App\Services\Soundblock\ProjectNoteAttachment;

class ProjectNoteAttach {
    protected ProjectNoteAttachment $noteAttachService;

    /**
     * Create the event listener.
     *
     * @param ProjectNoteAttachment $noteAttachService
     */
    public function __construct(ProjectNoteAttachment $noteAttachService) {
        $this->noteAttachService = $noteAttachService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event) {
        $arrParams = [];
        $objNote = $event->objNote;
        $urls = $event->urls;

        foreach ($urls as $url) {
            $arrParams["attachment_url"] = $url;
            $this->noteAttachService->create($objNote, $arrParams);
        }

    }
}
