<?php

namespace App\Mail\System\Notification;

use App\Models\Support\Ticket\SupportTicket;
use App\Models\Support\Ticket\SupportTicketMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Ticket extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    /**
     * @var SupportTicket
     */
    private SupportTicket $objTicket;
    private string $strAction;
    /**
     * @var SupportTicketMessage|null
     */
    private ?SupportTicketMessage $objMsg;
    private ?string $strSubject;

    /**
     * Create a new message instance.
     *
     * @param SupportTicket $objTicket
     * @param string $strAction
     * @param SupportTicketMessage|null $objMsg
     * @param string|null $strSubject
     */
    public function __construct(SupportTicket $objTicket, string $strAction, ?SupportTicketMessage $objMsg = null, ?string $strSubject = null) {
        $this->objTicket = $objTicket;
        $this->strAction = $strAction;
        $this->objMsg = $objMsg;
        $this->strSubject = $strSubject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $frontendUrl = app_url("office", "http://localhost:8200") . "customers/support/tickets/" . $this->objTicket->ticket_uuid;

        return $this->view('mail.system.notification.ticket')->from("office@support.arena.com", "Arena Office")
                    ->subject($this->strSubject ?? $this->strAction)
                    ->with(["link" => $frontendUrl, "ticket" => $this->objTicket, "action" => $this->strAction, "objMsg" => $this->objMsg]);
    }
}
