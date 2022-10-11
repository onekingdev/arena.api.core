<?php

namespace App\Repositories\Office;

use App\Repositories\BaseRepository;
use App\Models\Support\Ticket\SupportTicketAttachment as SupportTicketAttachmentModel;

class SupportTicketAttachment extends BaseRepository {
    public function __construct(SupportTicketAttachmentModel $objAttach) {
        $this->model = $objAttach;
    }
}
