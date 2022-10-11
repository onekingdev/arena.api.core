<?php

namespace App\Mail\Core\Support;

use App\Models\Support\Ticket\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketReply extends Mailable implements ShouldQueue{
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
        $soundTicketUrl = null;
        $objSupport = $this->objTicket->support;
        $objSupportApp = $objSupport->app;
        $arrConfig = config("constant.email.$objSupportApp->app_name");

        $appUrl = app_url($objSupportApp->app_name, app_url("merch.$objSupportApp->app_name", app_url("soundblock")));

        if ($objSupportApp->app_name == "soundblock") {
            $soundTicketUrl = $appUrl . "/support?ticket_id=" . $this->objTicket->ticket_uuid;
        }

        return $this->view('mail.core.support.reply')->from($arrConfig["address"], $arrConfig["name"])
                    ->subject("Support Ticket Reply ({$this->objTicket->ticket_title})")
                    ->with(["ticket" => $this->objTicket, "app" => $objSupportApp, "url" => $appUrl, "sound_url" => $soundTicketUrl]);
    }
}
