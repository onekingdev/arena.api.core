<?php

namespace App\Events\Common;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Support\Ticket\SupportTicket as SupportTicketModel;

class UpdateSupportTicket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var SupportTicketModel */
    private SupportTicketModel $objTicket;
    private string $appName;

    /**
     * Create a new event instance.
     *
     * @param SupportTicketModel $objTicket
     * @param string $appName
     */
    public function __construct(SupportTicketModel $objTicket, string $appName)
    {
        $this->objTicket = $objTicket;
        $this->appName = $appName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(){
        return new PrivateChannel(sprintf("channel.app.%s.support.ticket.%s", $this->appName, $this->objTicket->ticket_uuid));
    }

    public function broadcastAs() {
        return ("Soundblock.Support.Ticket.{$this->objTicket->ticket_uuid}");
    }

    public function broadcastWith() {
        $arrData = [];
        $arrData["ticket"] = $this->objTicket->toArray();
        $arrData["messages"] = $this->objTicket->messages->toArray();
        $arrData["attachments"] = $this->objTicket->attachments->toArray();

        return ($arrData);
    }
}
