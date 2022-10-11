<?php

namespace App\Listeners\Soundblock;

use App\Services\Soundblock\AccountNoteAttach as AccountNoteAttachService;

class AccountNoteAttach {
    protected AccountNoteAttachService $attachService;

    /**
     * Create the event listener.
     *
     * @param AccountNoteAttachService $attachService
     */
    public function __construct(AccountNoteAttachService $attachService) {
        $this->attachService = $attachService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event) {
        $objNote = $event->objNote;
        $urls = $event->urls;

        foreach ($urls as $url) {
            $arrParams = [];
            $arrParams["attachment_url"] = $url;

            $this->attachService->create($objNote, $arrParams);
        }

    }
}
