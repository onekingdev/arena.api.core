<?php

namespace App\Http\Transformers\Office\Support;

use App\Http\Transformers\BaseTransformer;
use App\Models\Support\Ticket\SupportTicketMessage as SupportTicketMessageModel;
use App\Traits\StampCache;
use Util;

class SupportTicketMessage extends BaseTransformer
{

    use StampCache;

    public function transform(SupportTicketMessageModel $objMsg)
    {
        $response = [
            "message_uuid" => $objMsg->message_uuid,
            "ticket_uuid" => $objMsg->ticket_uuid,
            "user" => [
                "data" => [
                    "user_uuid" => $objMsg->user->user_uuid,
                    "avatar_url" => Util::avatar_url($objMsg->user),
                    "name_first" => $objMsg->user->name_first,
                    "name_middle" => $objMsg->user->name_middle,
                    "name_last" => $objMsg->user->name_last,
                ]
            ],
            "message_text" => $objMsg->message_text,
            "flag_attachments" => $objMsg->flag_attachments,
            "flag_status" => $objMsg->flag_status,
            "flag_internal" => $objMsg->flag_officeonly
        ];

        return(array_merge($response, $this->stamp($objMsg)));
    }

    public function includeAttachments(SupportTicketMessageModel $objMsg)
    {
        return($this->collection($objMsg->attachments, new SupportTicketAttachment));
    }
}
