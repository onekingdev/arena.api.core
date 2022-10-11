<?php

namespace App\Http\Controllers\Core\Services\Support;

use Client;
use Exception;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\{
    Office\SupportTicketMessage as SupportTicketMessageService,
    Office\SupportTicket
};
use App\Http\{Controllers\Controller,
    Requests\Office\Support\CreateSupportTicketMessage,
    Transformers\Office\Support\SupportTicketMessage as SupportTicketMessageTransformer
};

/**
 * @group Core Support
 *
 */
class SupportTicketMessage extends Controller {
    /** @var SupportTicket */
    private SupportTicket $ticketService;
    /** @var SupportTicketMessageService */
    private SupportTicketMessageService $msgService;

    /**
     * @param SupportTicket $ticketService
     * @param SupportTicketMessageService $msgService
     */
    public function __construct(SupportTicket $ticketService, SupportTicketMessageService $msgService) {
        $this->ticketService = $ticketService;
        $this->msgService = $msgService;
    }

    /**
     * @param string $ticket
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|object
     */
    public function index(string $ticket, Request $request) {
        /** @var User $user */
        $user = Auth::user();
        $appOffice = Client::app()->app_name === "office";

        if ($appOffice) {
            $objTicket = $this->ticketService->find($ticket);
        } else {
            $objTicket = $this->ticketService->checkTicketUserForCore($user, $ticket);

            if (!$objTicket) {
                return ($this->apiReject(null, "Ticket not found.", 400));
            }
        }

        [$messages, $availableMetaData] = $this->msgService->getMessages($request->all(), $objTicket, $request->input("per_page", 10), true, $appOffice);

        return ($this->paginator($messages, new SupportTicketMessageTransformer(["attachments"])));
    }

    public function getUserUnreadSupportMessages(){
        $objUser = Auth::user();
        $unreadUserMessages = $this->msgService->getUserUnreadMessages($objUser);

        return ($this->apiReply(["count_messages" => $unreadUserMessages->count()], "", Response::HTTP_OK));
    }

    /**
     * @param CreateSupportTicketMessage $objRequest
     * @param SupportTicketMessageService $msgService
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function storeMessage(CreateSupportTicketMessage $objRequest, SupportTicketMessageService $msgService) {
        $objApp = Client::app();

        if ($objApp->app_name == "office" && !is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $bnOffice = $objApp->app_name == "office";
        $objMsg = $msgService->create($bnOffice, $objRequest->all());

        return ($this->item($objMsg, new SupportTicketMessageTransformer(["attachments"])));
    }
}
