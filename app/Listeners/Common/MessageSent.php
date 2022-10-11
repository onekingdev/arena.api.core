<?php

namespace App\Listeners\Common;

use Util;
use App\Models\{Core\App, Users\Contact\UserContactEmail};
use Illuminate\Mail\Events\MessageSent as MessageSentEvent;
use App\Services\{User, Email, User\UserCorrespondence};

class MessageSent {
    /**
     * @var User
     */
    private User $userService;
    /**
     * @var UserCorrespondence
     */
    private UserCorrespondence $correspondenceService;
    /**
     * @var Email
     */
    private Email $emailService;

    /**
     * Create the event listener.
     * @param User $userService
     * @param UserCorrespondence $correspondenceService
     * @param Email $emailService
     *
     * @return void
     */
    public function __construct(User $userService, UserCorrespondence $correspondenceService, Email $emailService) {
        $this->userService = $userService;
        $this->correspondenceService = $correspondenceService;
        $this->emailService = $emailService;
    }

    /**
     * Handle the event.
     *
     * @param MessageSentEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(MessageSentEvent $event) {
        try {
            /**
             * @var array $recpients
             */
            $arrEmails = array_keys($event->message->getTo());
            /**
             * @var App
             */
            $app = $event->message->app;
            $from = array_keys($event->message->getFrom());
            $uuid = Util::uuid();

            foreach ($arrEmails as $strEmail) {
                /** @var UserContactEmail */
                $email = $this->emailService->find($strEmail);
                if (!$email)
                    continue;
                $user = $email->user;
                $params = [
                    "email_id"      => $event->message->getId(),
                    "email_uuid"    => $uuid,
                    "email_subject" => $event->message->getSubject(),
                    "email_from"    => $from[0],
                    "email_text"    => "Sample Text",
                    "email_html"    => $event->message->getBody(),
                ];
                $this->correspondenceService->create($params, $user, $app);
            }
        } catch (\Exception $exception) {
            return;
        }
    }
}
