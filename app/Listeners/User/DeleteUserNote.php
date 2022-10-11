<?php

namespace App\Listeners\User;

use App\Services\User\UserNoteAttachment;

class DeleteUserNote {
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

        $this->attachService->delete($objNote);
    }
}
