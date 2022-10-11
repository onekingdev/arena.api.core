<?php

namespace App\Http\Controllers\Office;

use Auth;
use Client;
use Exception;
use App\Models\Users\User;
use Illuminate\Http\Response;
use App\Services\{
    Core\Auth\AuthGroup,
    User as UserService,
    Office\SupportTicket as SupportTicketService
};
use App\Http\{
    Controllers\Controller,
    Requests\Office\Support\EditTicket,
    Requests\Office\Support\CreateOfficeTicket,
    Requests\Office\Support\AssignUser,
    Requests\Office\Support\DetachUser,
    Requests\Office\Support\GetAllSupport,
    Requests\Office\Support\UpdateSupportTicket
};

/**
 * @group Office Support
 *
 */
class SupportTicket extends Controller {
    /** @var SupportTicketService */
    private SupportTicketService $supportTicketService;

    /**
     * @param SupportTicketService $supportTicketService
     */
    public function __construct(SupportTicketService $supportTicketService) {
        $this->supportTicketService = $supportTicketService;
    }

    /**
     * @param GetAllSupport $objRequest
     * @param AuthGroup $authGroupService
     * @return object
     * @throws Exception
     */
    public function index(GetAllSupport $objRequest, AuthGroup $authGroupService) {
        /** @var User $user*/
        $user = Auth::user();

        if (!is_authorized($user, "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $perPage = $objRequest->get("per_page", 10);
        /** @var \Illuminate\Database\Eloquent\Collection */
        $userGroups = $authGroupService->findByUser($user->user_uuid, $perPage, false);
        /** @var array */
        $groupIds = $userGroups->pluck("group_id")->toArray();

        [$objTickets, $availableMetaData] = $this->supportTicketService->findAll($objRequest->all(), $perPage, $groupIds, $user);

        return ($this->apiReply($objTickets, "", Response::HTTP_OK, $availableMetaData));
    }

    /**
     * @param string $ticket
     * @return object
     * @throws Exception
     */
    public function show(string $ticket) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTicket = $this->supportTicketService->showForOffice($ticket);

        return ($this->apiReply($objTicket));
    }

    /**
     * @param CreateOfficeTicket $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function store(CreateOfficeTicket $objRequest) {
        /** @var User $objUser */
        $objUser = Auth::user();

        if (!is_authorized($objUser, "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTicket = $this->supportTicketService->creteOfficeTicket($objUser, $objRequest->all());

        return (
        $this->apiReply(
            $objTicket->load(
                "support", "user", "supportUser", "supportGroup", "messages", "messages.attachments"
            ),
            "",
            201
        )
        );
    }

    /**
     * @param UpdateSupportTicket $objRequest
     * @return object
     * @throws Exception
     */
    public function update(UpdateSupportTicket $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTicket = $this->supportTicketService->find($objRequest->ticket);
        $objTicket = $this->supportTicketService->update($objTicket, $objRequest->all());

        return ($this->apiReply($objTicket->load("support")));
    }

    /**
     * @param EditTicket $objRequest
     * @param string $ticket
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function editTicket(EditTicket $objRequest, string $ticket){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objTicket = $this->supportTicketService->find($ticket);
        $boolResult = $this->supportTicketService->edit($objTicket, $objRequest->all());

        if (!$boolResult) {
            return ($this->apiReject(null, "Invalid request parameters.", 400));
        }

        return ($this->apiReply(null, "Ticket updated successfully.", 200));
    }

    /**
     * @param AssignUser $request
     * @param string $ticket
     * @param UserService $userService
     * @param AuthGroup $authGroupService
     * @return object
     * @throws Exception
     */
    public function attachMembers(AssignUser $request, string $ticket, UserService $userService, AuthGroup $authGroupService) {
        $objApp = Client::app();

        try {
            /** @var \App\Models\Support\Ticket\SupportTicket */
            $objTicket = $this->supportTicketService->find($ticket, true);
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, 10, false);
            $groupIds = $userGroups->pluck("group_id");

            if ($this->supportTicketService->checkAccessToTicket($objTicket, $user, $groupIds)) {
                if ($request->has("users")) {
                    $users = $userService->findAllWhere($request->input("users"));
                    $this->supportTicketService->attachUsers($objTicket, $users);
                }

                if ($request->has("groups") && $objApp->app_name == "office") {
                    $group = $authGroupService->findAllWhere($request->input("groups"));
                    $this->supportTicketService->attachGroup($objTicket, $group);
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
     * @param AssignUser $request
     * @param string $ticket
     * @param UserService $userService
     * @param AuthGroup $authGroupService
     * @return object
     * @throws Exception
     */
    public function attachMember(AssignUser $request, string $ticket, UserService $userService, AuthGroup $authGroupService) {
        $objApp = Client::app();

        try {
            /** @var \App\Models\Support\Ticket\SupportTicket */
            $objTicket = $this->supportTicketService->find($ticket, true);
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, 10, false);
            $groupIds = $userGroups->pluck("group_id");

            if ($this->supportTicketService->checkAccessToTicket($objTicket, $user, $groupIds)) {
                if ($request->has("user")) {
                    $users = $userService->findAllWhere([$request->input("user")]);
                    $this->supportTicketService->attachUsers($objTicket, $users);
                }

                if ($request->has("group") && $objApp->app_name == "office") {
                    $group = $authGroupService->findAllWhere([$request->input("group")]);
                    $this->supportTicketService->attachGroup($objTicket, $group);
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
    public function detachMembers($ticket, DetachUser $request, UserService $userService, AuthGroup $authGroupService) {
        $objApp = Client::app();

        try {
            /** @var \App\Models\Support\Ticket\SupportTicket */
            $objTicket = $this->supportTicketService->find($ticket);
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, 10, false);
            $groupIds = $userGroups->pluck("group_id");

            if ($objApp->app_name == "office" && $this->supportTicketService->checkAccessToTicket($objTicket, $user, $groupIds, true)) {
                if ($request->has("users")) {
                    $users = $userService->findAllWhere($request->input("users"));
                    $this->supportTicketService->detachUser($objTicket, $users);
                }

                if ($request->has("groups")) {
                    $group = $authGroupService->findAllWhere([$request->input("group")]);
                    $this->supportTicketService->detachGroup($objTicket, $group);
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
            $objTicket = $this->supportTicketService->find($ticket);
            $user = Auth::user();
            $userGroups = $authGroupService->findByUser($user->user_uuid, 10, false);
            $groupIds = $userGroups->pluck("group_id");

            if ($objApp->app_name == "office" && $this->supportTicketService->checkAccessToTicket($objTicket, $user, $groupIds, true)) {
                if ($request->has("user")) {
                    $users = $userService->findAllWhere([$request->input("user")]);
                    $this->supportTicketService->detachUser($objTicket, $users);
                }

                if ($request->has("group")) {
                    $group = $authGroupService->find([$request->input("group"), true]);
                    $this->supportTicketService->detachGroup($objTicket, $group);
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
