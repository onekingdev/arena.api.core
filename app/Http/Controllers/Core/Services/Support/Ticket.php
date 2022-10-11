<?php

namespace App\Http\Controllers\Core\Services\Support;

use Auth;
use Client;
use Builder;
use Exception;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Mail\System\Notification\Ticket as TicketMail;
use App\Models\Support\Ticket\SupportTicket as SupportTicketModel;
use Illuminate\Support\Facades\Mail;
use App\Services\{
    User as UserService,
    Core\Auth\AuthGroup,
    Office\SupportTicket as SupportTicketService,
    Common\App as AppService
};
use App\Http\Requests\{
    Core\Services\Support\CoreGetAllSupport,
    Core\Services\Support\DetachUser,
    Core\Services\Support\CreateCoreTicket,
    Office\Support\UpdateSupportTicket,
    Core\Services\Support\AttachUser
};

/**
 * @group Core Support
 *
 */
class Ticket extends Controller {
    /** @var SupportTicketService */
    private SupportTicketService $ticketService;
    /** @var AppService */
    private AppService $appService;

    /**
     * @param SupportTicketService $ticketService
     * @param AppService $appService
     */
    public function __construct(SupportTicketService $ticketService, AppService $appService) {
        $this->ticketService = $ticketService;
        $this->appService = $appService;
    }

    /**
     * @param CoreGetAllSupport $objRequest
     * @return object
     */
    public function index(CoreGetAllSupport $objRequest) {
        $arrTickets = $this->ticketService->findAllForOffice($objRequest->all(), $objRequest->input("per_page", 10));

        return ($this->apiReply($arrTickets));
    }

    /**
     * @param string $ticket
     * @return object
     * @throws Exception
     */
    public function show(string $ticket) {
        $objTicket = $this->ticketService->find($ticket);

        if (!$this->ticketService->checkTicketEqualUser($objTicket, Auth::user())) {
            abort(404, "Users ticket not found.");
        }

        $objTicket->load([
            "support"  => function ($query) {
                $query->with("app");
            },
            "messages" => function ($query) {
                $query->where("flag_office", false);
                $query->orderBy(SupportTicketModel::STAMP_CREATED, "asc");
            },
            "messages.attachments",
        ]);

        return ($this->apiReply($objTicket));
    }

    /**
     * @param CreateCoreTicket $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function store(CreateCoreTicket $objRequest) {
        $objApp = Client::app();
        $objUser = Auth::user();

        if ($this->ticketService->checkTicketDuplicate($objUser->user_uuid, $objRequest->input("title"))) {
            return ($this->apiReject(null, "Ticket already exists.", Response::HTTP_BAD_REQUEST));
        }

        [$objTicket, $objMsg] = $this->ticketService->creteCoreTicket($objUser, $objApp, $objRequest->all(), $objApp->app_name == "office");

        if ($objApp->app_name == "soundblock") {
            $arrMailTo = ["swhite@arena.com"];

            if (config("app.env") === "prod") {
                $arrMailTo = ["swhite@arena.com", "devans@arena.com", "ajohnson@soundblock.com"];
            }

            Mail::to($arrMailTo)->send(new TicketMail($objTicket, "Support Ticket: " . $objTicket->user->name . ": " . $objTicket->ticket_title, $objMsg));
        }

        $strAppName = ucfirst($objApp->app_name);
        $objApp = $this->appService->findOneByName("office");
        $strMemo = "&quot;{$objTicket->ticket_title}&quot; by {$objUser->name} <br> {$strAppName} &bull; {$objTicket->support->support_category}";
        $strUrl = app_url("office") . "customers/support/tickets/" . $objTicket->ticket_uuid;

        notify_group("App.Office.Support", $objApp, "New Support Ticket", $strMemo, Builder::notification_link([
            "link_name" => "View Ticket",
            "url"       => $strUrl,
        ]), $strUrl);

        return (
            $this->apiReply($objTicket->load("support", "user", "supportUser", "supportGroup", "messages", "messages.attachments"),
                "", 201)
        );
    }

    /**
     * @param UpdateSupportTicket $objRequest
     * @return object
     * @throws Exception
     */
    public function update(UpdateSupportTicket $objRequest) {
        $objTicket = $this->ticketService->find($objRequest->ticket);

        if ( !is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office") ) {
            if (!$this->ticketService->checkTicketEqualUser($objTicket, Auth::user())) {
                abort(404, "Users ticket not found.");
            }
        }

        $objTicket = $this->ticketService->update($objTicket, $objRequest->all());

        return ($this->apiReply($objTicket->load("support")));
    }

    /**
     * @param AttachUser $request
     * @param string $ticket
     * @param UserService $userService
     * @param AuthGroup $authGroupService
     * @return object
     * @throws Exception
     */
    public function attachMember(AttachUser $request, string $ticket, UserService $userService, AuthGroup $authGroupService) {
        $objApp = Client::app();

        try {
            /** @var \App\Models\Support\Ticket\SupportTicket */
            $objTicket = $this->ticketService->find($ticket, true);
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, 10, false);
            $groupIds = $userGroups->pluck("group_id");

            if ($this->ticketService->checkAccessToTicket($objTicket, $user, $groupIds)) {
                if ($request->has("user")) {
                    $users = $userService->findAllWhere([$request->input("user")]);
                    $this->ticketService->attachUsers($objTicket, $users);
                }

                if ($request->has("group") && $objApp->app_name == "office") {
                    $group = $authGroupService->findAllWhere([$request->input("group")]);
                    $this->ticketService->attachGroup($objTicket, $group);
                }
            } else {
                abort(403, "You have not access to this ticket");
            }

            return ($this->apiReply($objTicket->load("support")));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $ticket
     * @param DetachUser $request
     * @param UserService $userService
     * @param AuthGroup $authGroupService
     * @return object
     * @throws Exception
     */
    public function detachMember($ticket, DetachUser $request, UserService $userService, AuthGroup $authGroupService) {
        $objApp = Client::app();

        try {
            $objTicket = $this->ticketService->find($ticket);
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, 10, false);
            $groupIds = $userGroups->pluck("group_id");

            if ($objApp->app_name == "office" && $this->ticketService->checkAccessToTicket($objTicket, $user, $groupIds, true)) {
                if ($request->has("user")) {
                    $users = $userService->findAllWhere([$request->input("user")]);
                    $this->ticketService->detachUser($objTicket, $users);
                }

                if ($request->has("group")) {
                    $group = $authGroupService->find([$request->input("group"), true]);
                    $this->ticketService->detachGroup($objTicket, $group);
                }
            } else {
                abort(403, "You have not access to this ticket");
            }

            return ($this->apiReply($objTicket->load("support")));
        } catch (Exception $e) {
            throw $e;
        }
    }
}
