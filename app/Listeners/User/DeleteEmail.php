<?php

namespace App\Listeners\User;

use App\Services\Email;
use App\Models\Users\User;

class DeleteEmail {
    /** @var Email */
    protected Email $emailService;

    /**
     * Create the event listener.
     * @param Email $emailService
     * @return void
     */
    public function __construct(Email $emailService) {
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     * @throws \Exception
     */
    public function handle($event) {
        /** @var User $user */
        $user = $event->user;
        $hasPrimary = $this->emailService->hasPrimary($user);
        if (!$hasPrimary) {
            $verifiedEmails = $this->emailService->verifiedEmails($user);
            if ($verifiedEmails->isNotEmpty()) {
                $this->emailService->update($verifiedEmails->first(), $user, ["flag_primary" => true]);
            } else {
                $this->emailService->update($user->emails->first(), $user, ["flag_primary" => true]);
            }
        }
    }
}
