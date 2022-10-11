<?php

namespace App\Http\Controllers\Office;

use Client;
use Exception;
use App\Services\{
    Core\Auth\AuthGroup,
    Office\SupportTicketMessage as SupportTicketMessageService,
    Office\SupportTicket
};
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Support\CreateSupportTicketMessage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Transformers\Office\Support\SupportTicketMessage as SupportTicketMessageTransformer;

/**
 * @group Office Support
 *
 */
class SupportTicketMessage extends Controller {
    /** @var SupportTicketMessageService */
    private SupportTicketMessageService $supportTicketMessageService;

    /**
     * @param SupportTicketMessageService $supportTicketMessageService
     */
    public function __construct(SupportTicketMessageService $supportTicketMessageService) {
        $this->supportTicketMessageService = $supportTicketMessageService;
    }

    /**
     * @param string $ticket
     * @param Request $request
     * @param SupportTicket $ticketService
     * @param AuthGroup $authGroupService
     * @return object
     * @throws Exception
     */
    public function index(string $ticket, Request $request, SupportTicket $ticketService, AuthGroup $authGroupService) {
        $perPage = $request->input("per_page", 10);

        try {
            /** @var User $user */
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, $perPage, false);
            $groupIds = $userGroups->pluck("group_id");
            $objTicket = $ticketService->find($ticket);

            if (!$ticketService->checkAccessToTicket($objTicket, $user, $groupIds, true)) {
                throw new NotFoundHttpException("Ticket Not Found");
            }

            if (Client::app()->app_name == "office") {
                [$objMessages, $availableMetaData] = $this->supportTicketMessageService->getMessages($request->all(), $objTicket, $perPage);
            } else {
                [$objMessages, $availableMetaData] = $this->supportTicketMessageService->getMessages($request->all(), $objTicket, $perPage, true);
            }

            return ($this->apiReply($objMessages, "", Response::HTTP_OK, $availableMetaData));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param CreateSupportTicketMessage $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function storeMessage(CreateSupportTicketMessage $objRequest) {
        $bnOffice = $objRequest->get("flag_office");
        $objMsg = $this->supportTicketMessageService->create($bnOffice, $objRequest->all());

        return ($this->item($objMsg, new SupportTicketMessageTransformer(["attachments"])));
    }
}
