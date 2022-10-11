<?php

namespace App\Listeners\Office\Support;

use App\Services\Office\SupportTicketAttachment;

class TicketAttach {
    protected SupportTicketAttachment $attachService;

    /**
     * Create the event listener.
     *
     * @param SupportTicketAttachment $attachService
     */
    public function __construct(SupportTicketAttachment $attachService) {
        $this->attachService = $attachService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event) {
        $objMsg = $event->objMsg;
        $arrMeta = $event->arrMeta;

        foreach ($arrMeta as $meta) {
            $arrParams = [];
            $arrParams["attachment_name"] = $meta["attachment_name"];
            $arrParams["attachment_url"] = $meta["attachment_url"];

            $this->attachService->create($objMsg, $arrParams);
        }
    }
}
