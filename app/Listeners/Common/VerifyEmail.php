<?php

namespace App\Listeners\Common;

use App\Services\Email;

class VerifyEmail {
    protected Email $emailService;

    /**
     * Create the event listener.
     *
     * @param Email $emailService
     */
    public function __construct(Email $emailService) {
        //
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event) {
        /** @var \App\Models\Users\Contact\UserContactEmail */
        $objEmail = $event->objEmail;

        $this->emailService->sendVerificationEmail($objEmail);
    }
}
