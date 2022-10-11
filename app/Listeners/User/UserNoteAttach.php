<?php

namespace App\Listeners\User;

use App\Services\User\UserNoteAttachment;

class UserNoteAttach {

    protected UserNoteAttachment $attachService;

    /**
     * Create the event listener.
     *
     * @param UserNoteAttachment $attachService
     */
    public function __construct(UserNoteAttachment $attachService) {
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
        $arrUrls = $event->arrUrls;

        foreach ($arrUrls as $url) {
            $arrParams = [];

            $arrParams["note"] = $objNote;
            $arrParams["attachment_url"] = $url;
            $this->attachService->create($arrParams);
        }
    }
}
