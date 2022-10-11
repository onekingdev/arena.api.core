<?php

namespace App\Http\Transformers\Office\Support;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Support\Ticket\SupportTicketAttachment as SupportTicketAttachmentModel;

class SupportTicketAttachment extends BaseTransformer
{

    use StampCache;
    public function transform(SupportTicketAttachmentModel $objAttach)
    {
        $response = [
            "attachment_name" => $objAttach->attachment_name,
            "attachment_url" => $objAttach->attachment_url,
        ];

        return(array_merge($response, $this->stamp($objAttach)));
    }
}
