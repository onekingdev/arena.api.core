<?php

namespace App\Services\Office;

use Util;
use App\Repositories\Office\SupportTicketAttachment as SupportTicketAttachmentRepository;
use App\Models\{Support\Ticket\SupportTicketAttachment as SupportTicketAttachmentModel, Support\Ticket\SupportTicketMessage};

class SupportTicketAttachment {
    /** @var SupportTicketAttachmentRepository */
    private SupportTicketAttachmentRepository $attachRepo;

    public function __construct(SupportTicketAttachmentRepository $attachRepo) {
        $this->attachRepo = $attachRepo;
    }

    public function create(SupportTicketMessage $objMsg, array $arrParams) {
        $objAttach = new SupportTicketAttachmentModel;
        $arrAttach = [];

        $arrAttach["row_uuid"] = Util::uuid();
        $arrAttach["ticket_id"] = $objMsg->ticket->ticket_id;
        $arrAttach["ticket_uuid"] = $objMsg->ticket->ticket_uuid;
        $arrAttach["message_id"] = $objMsg->message_id;
        $arrAttach["message_uuid"] = $objMsg->message_uuid;
        $arrAttach["attachment_name"] = $arrParams["attachment_name"];
        $arrAttach["attachment_url"] = $arrParams["attachment_url"];

        $objAttach->fill($arrAttach);
        $objAttach->save();

        return ($objAttach);
    }

    public function update(SupportTicketMessage $objAttach, array $arrParams) {
        $arrAttach = [];

        if (isset($arrParams["attachment_name"])) {
            $arrAttach["attachment_name"] = $arrParams["attachment_name"];
        }

        return ($this->attchRepo->update($objAttach, $arrAttach));
    }
}
