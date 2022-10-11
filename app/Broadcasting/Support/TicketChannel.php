<?php

namespace App\Broadcasting\Support;

use App\Models\Users\User;
use App\Services\Office\SupportTicket;

class TicketChannel {

    protected SupportTicket $ticketService;

    /**
     * Create a new channel instance.
     *
     * @param SupportTicket $ticketService
     */
    public function __construct(SupportTicket $ticketService) {
        $this->ticketService = $ticketService;
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param string $ticket
     * @return array|bool
     */
    public function join(User $user, string $ticket) {
        $objTicket = $this->ticketService->find($ticket);

        return (
            $objTicket->user->user_id == $user->user_id ||
            $objTicket->supportUser()->where("users.user_uuid", $user->user_uuid)->exists()
        );
    }
}
