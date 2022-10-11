<?php

namespace App\Repositories\Office;

use App\Models\Support\Ticket\SupportTicket;
use App\Models\Support\Ticket\SupportTicketMessage as SupportTicketMessageModel;
use App\Repositories\BaseRepository;

class SupportTicketMessage extends BaseRepository {

    public function __construct(SupportTicketMessageModel $objMessage) {
        $this->model = $objMessage;
    }

    public function getMessages(array $arrParams, SupportTicket $ticket, int $perPage = 10, bool $withoutOffice = false){
        $query = $ticket->messages();

        if ($withoutOffice) {
            $query = $query->where("flag_officeonly", false)->orderBy("stamp_created_at", "desc");
        }

        [$query, $availableMetaData] = $this->applyMetaFilters($arrParams, $query);

        $objMessages = $query->with(["user", "attachments"])->paginate($perPage);

        return ([$objMessages, $availableMetaData]);
    }

    public function getUserUnreadMessages(string $user_uuid){
        $unreadUserMessages = $this->model->where("flag_status", "Unread")
            ->where("user_uuid", "!=", $user_uuid)
            ->where("flag_office", 1)
            ->where("flag_officeonly", 0)
            ->whereHas("ticket.supportUser", function ($query) use ($user_uuid){
                $query->where("support_tickets_users.user_uuid", $user_uuid);
            })
            ->get();

        return ($unreadUserMessages);
    }
}
