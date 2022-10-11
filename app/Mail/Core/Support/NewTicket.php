<?php

namespace App\Mail\Core\Support;

use App\Models\Support\Ticket\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTicket extends Mailable {
    use Queueable, SerializesModels;

    /**
     * @var SupportTicket
     */
    private SupportTicket $objTicket;

    /**
     * Create a new message instance.
     *
     * @param SupportTicket $objTicket
     */
    public function __construct(SupportTicket $objTicket) {
        $this->objTicket = $objTicket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('mail.core.support.new')->from("office@support.arena.com", "Arena Office")
                    ->subject("New Ticket's Reply")->with(["ticket" => $this->objTicket]);
    }
}
