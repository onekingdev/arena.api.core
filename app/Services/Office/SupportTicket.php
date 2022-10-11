<?php

namespace App\Services\Office;

use Client;
use Util;
use Illuminate\Support\Collection;
use App\Mail\Core\Support\NewTicket;
use Illuminate\Support\Facades\Mail;
use App\Repositories\{
    Common\App as AppRepository,
    Core\Auth\AuthGroup as AuthGroupRepository,
    Office\Support,
    Office\SupportTicket as SupportTicketRepository,
    User\User as UserRepository
};
use App\Models\{
    Core\Auth\AuthGroup,
    BaseModel,
    Core\App,
    Support\Ticket\SupportTicket as SupportTicketModel,
    Users\User
};

class SupportTicket {

    protected SupportTicketRepository $ticketRepo;
    protected Support $supportRepo;
    protected UserRepository $userRepo;
    /** @var AuthGroupRepository */
    private AuthGroupRepository $authGroupRepository;
    /** @var AppRepository */
    private AppRepository $appRepository;
    /** @var SupportTicketMessage */
    private SupportTicketMessage $messageService;

    /**
     * SupportTicketService constructor.
     * @param SupportTicketRepository $ticketRepo
     * @param Support $supportRepo
     * @param UserRepository $userRepo
     * @param AuthGroupRepository $authGroupRepository
     * @param AppRepository $appRepository
     * @param SupportTicketMessage $messageService
     */
    public function __construct(SupportTicketRepository $ticketRepo, Support $supportRepo, UserRepository $userRepo,
                                AuthGroupRepository $authGroupRepository, AppRepository $appRepository,
                                SupportTicketMessage $messageService) {
        $this->ticketRepo = $ticketRepo;
        $this->supportRepo = $supportRepo;
        $this->userRepo = $userRepo;
        $this->authGroupRepository = $authGroupRepository;
        $this->appRepository = $appRepository;
        $this->messageService = $messageService;
    }

    public function find(string $ticket, ?bool $bnFailure = true) {
        return ($this->ticketRepo->find($ticket, $bnFailure));
    }

    /**
     * @param array $arrParams
     * @param int $perPage
     * @param array $groups
     * @param User $user
     *
     * @return array
     */
    public function findAll(array $arrParams, int $perPage = 10, ?array $groups = null, ?User $user = null) {
        [$objTickets, $availableMetaData] = $this->ticketRepo->findAll($arrParams, $perPage, $groups, $user);

        return ([$objTickets, $availableMetaData]);
    }

    /**
     * @param array $arrParams
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllForOffice(array $arrParams, int $perPage = 10) {
        return ($this->ticketRepo->findAllForOffice($arrParams, $perPage));
    }

    public function showForOffice(string $ticket){
        $objTicket = $this->find($ticket);
        $objUser = $this->userRepo->find($objTicket->user_uuid);

        $objTicket->load([
            "support"  => function ($query) {
                $query->with("app");
            },
            "messages" => function ($query) {
                $query->where("flag_office", true);
                $query->orderBy(SupportTicketModel::STAMP_CREATED, "asc");
            },
            "messages.attachments",
            "supportUser" => function ($query) {
                $query->where("support_tickets_users.flag_active", true);
            },
            "supportGroup" => function ($query) {
                $query->where("support_tickets_groups.flag_active", true);
            },
        ]);

        if (!empty($objTicket->supportUser)) {
            foreach ($objTicket->supportUser as $key => $supportUser) {
                unset($objTicket->supportUser[$key]->avatar_name);
                $objTicket->supportUser[$key]->avatar = $supportUser->avatar;
            }
        }

        $objTicket->user_name = $objUser->name;
        $objTicket->user_avatar = $objUser->avatar;

        $sentryApiUrl = config("constant.sentry.sentry_arena_issues_url") . "?" . http_build_query([
                "project" => config("constant.sentry.sentry_arena_api_id"),
                "query" => "user.id:" . $objUser->user_uuid,
                "statsPeriod" => "14d"
            ]);
        $sentryAppUrl = null;

        if (!is_null($objTicket->support->app->sentry_id)) {
            $sentryAppUrl = config("constant.sentry.sentry_arena_issues_url") . "?" . http_build_query([
                    "project" => $objTicket->support->app->sentry_id,
                    "query" => "user.id:" . $objUser->user_uuid,
                    "statsPeriod" => "14d"
                ]);
        }

        $objTicket->sentry_api_url = $sentryApiUrl;
        $objTicket->sentry_app_url = $sentryAppUrl;

        return ($objTicket);
    }

    /**
     * @param SupportTicketModel $ticket
     * @param User $user
     * @param Collection $groups
     * @param bool|null $isOffice
     * @return bool
     */
    public function checkAccessToTicket(SupportTicketModel $ticket, User $user, Collection $groups, ?bool $isOffice = null) {
        $userQuery = $ticket->supportUser()->where("users.user_id", $user->user_id)
            ->wherePivot("flag_active", true);

        if (isset($isOffice)) {
            $userQuery = $userQuery->wherePivot("flag_office", $isOffice);
        }

        $checkedUser = $userQuery->get()->isNotEmpty();

        $checkedGroup = $ticket->supportGroup()->whereIn("core_auth_groups.group_id", $groups)
            ->wherePivot("flag_active", true)->get()->isNotEmpty();


        return $checkedUser || $checkedGroup;
    }

    public function checkTicketEqualUser(SupportTicketModel $ticket, User $user){
        $checkUser = $ticket->supportUser()->where("users.user_id", $user->user_id)->get()->isNotEmpty();

        return ($checkUser);
    }

    public function checkTicketUserForCore(User $objUser, string $ticket){
        return ($this->ticketRepo->checkTicketUserForCore($objUser, $ticket));
    }

    public function checkTicketDuplicate(string $user_uuid, string $title){
        return ($this->ticketRepo->checkTicketDuplicate($user_uuid, $title));
    }

    /**
     * @param App $app
     * @param array $arrParams
     * @param User $user
     * @param bool $isOffice
     * @param AuthGroup|null $objGroup
     * @return SupportTicketModel
     * @throws \Exception
     */
    private function saveTicket(App $app, array $arrParams, User $user, $isOffice = false, ?AuthGroup $objGroup = null): SupportTicketModel {
        $arrTicket = [];

        $objSupport = $this->supportRepo->findWhere([
            "app_id"           => $app->app_id,
            "support_category" => $arrParams["support"],
        ]);

        $arrTicket["support_id"] = $objSupport->support_id;
        $arrTicket["support_uuid"] = $objSupport->support_uuid;
        $arrTicket["user_id"] = $user->user_id;
        $arrTicket["user_uuid"] = $user->user_uuid;
        $arrTicket["ticket_title"] = $arrParams["title"];
        $arrTicket["flag_status"] = "Open";

        /** @var SupportTicketModel $ticket */
        $ticket = $this->ticketRepo->create($arrTicket);
        $ticket->supportUser()->attach($user->user_id, [
            "row_uuid"    => Util::uuid(),
            "user_uuid"   => $user->user_uuid,
            "ticket_uuid" => $ticket->ticket_uuid,
            "flag_office" => $isOffice,
        ]);

        if (is_null($objGroup)) {
            $objGroup = $this->authGroupRepository->findByName("App.Office.Support");
        }

        $ticket->supportGroup()->attach($objGroup->group_id, [
            "row_uuid"    => Util::uuid(),
            "group_uuid"  => $objGroup->group_uuid,
            "ticket_uuid" => $ticket->ticket_uuid,
        ]);

        return $ticket;
    }

    public function creteOfficeTicket(User $objUserFrom, array $arrParams): SupportTicketModel {
        $objAuthUser = $objUserFrom;

        if (isset($arrParams["app_uuid"])) {
            $app = $this->appRepository->find($arrParams["app_uuid"]);
        } else {
            $app = Client::app();
        }

        $objGroup = null;

        if (isset($arrParams["from"]) && isset($arrParams["from_type"])) {
            if ($arrParams["from_type"] == "user") {
                $objUserFrom = $this->userRepo->find($arrParams["from"]);

                if (is_null($objUserFrom)) {
                    throw new \Exception("User From Not Found.");
                }
            } else if ($arrParams["from_type"] == "group") {
                $objGroup = $this->authGroupRepository->find($arrParams["from"]);
            }
        }

        $objTicket = $this->saveTicket($app, $arrParams, $objUserFrom, false, $objGroup);

         if (isset($arrParams["users"]) && is_array($arrParams["users"])) {
            foreach ($arrParams["users"] as $strUser) {
                $objUserTo = $this->userRepo->find($strUser, true);
                $bnExists = $objTicket->supportUser()->where("users.user_id", $objUserTo->user_id)->exists();

                if ($bnExists) {
                    continue;
                }

                $objTicket->supportUser()->attach($objUserTo->user_id, [
                    "row_uuid"    => Util::uuid(),
                    "user_uuid"   => $objUserTo->user_uuid,
                    "ticket_uuid" => $objTicket->ticket_uuid,
                    "flag_office" => true,
                ]);
            }
        }

        if (isset($arrParams["groups"]) && is_array($arrParams["groups"])) {
            foreach ($arrParams["groups"] as $strGroups) {
                $objGroup = $this->authGroupRepository->find($strGroups, true);

                $objTicket->supportGroup()->attach($objGroup->group_id, [
                    "row_uuid"    => Util::uuid(),
                    "group_uuid"  => $objGroup->group_uuid,
                    "ticket_uuid" => $objTicket->ticket_uuid,
                ]);
            }
        }

        if (isset($arrParams["message"])) {
            $arrMsgParams = [
                "ticket"          => $objTicket,
                "user"            => $objAuthUser,
                "flag_officeonly" => false,
                "message_text"    => $arrParams["message"]["text"],
            ];

            if (isset($arrParams["message"]["files"])) {
                $arrMsgParams["files"] = $arrParams["message"]["files"];
            }

            $this->messageService->create(true, $arrMsgParams, true);
        }

        if ($objAuthUser->user_id !== $objUserFrom->user_id) {
            Mail::to($objUserFrom->primary_email->user_auth_email)->send(new NewTicket($objTicket));
        }

        return $objTicket;
    }

    public function creteCoreTicket(User $objUser, App $app, array $arrParams, bool $flagOffice): array {
        $objMsg = null;
        $objTicket = $this->saveTicket($app, $arrParams, $objUser, $flagOffice, null);

        if (isset($arrParams["message"])) {
            $arrMsgParams = [
                "ticket"          => $objTicket,
                "user"            => $objUser,
                "flag_officeonly" => false,
                "message_text"    => $arrParams["message"]["text"],
            ];

            if (isset($arrParams["message"]["files"])) {
                $arrMsgParams["files"] = $arrParams["message"]["files"];
            }

            $objMsg = $this->messageService->create($flagOffice, $arrMsgParams, true);
        }

        return [$objTicket, $objMsg];
    }

    public function update(SupportTicketModel $objTicket, array $arrParams) {
        $arrTicket = [];

        if (isset($arrParams["flag_status"])) {
            $arrTicket["flag_status"] = Util::ucLabel($arrParams["flag_status"]);
        }

        return ($this->ticketRepo->update($objTicket, $arrTicket));
    }

    /**
     * @param $objTicket
     * @param array $arrParams
     * @return bool
     * @throws \Exception
     */
    public function edit($objTicket, array $arrParams){
        $ticketUsers = $objTicket->supportUser()->pluck("users.user_id");
        $ticketGroups = $objTicket->supportGroup()->pluck("core_auth_groups.group_id");
        foreach ($ticketUsers as $ticketUser){
            $objTicket->supportUser()->detach($ticketUser);
        }
        foreach ($ticketGroups as $ticketGroup){
            $objTicket->supportGroup()->detach($ticketGroup);
        }

        if ($arrParams["to_type"] == "user") {
            foreach ($arrParams["to"] as $userTo) {
                $objUserTo = $this->userRepo->find($userTo, true);

                $objTicket->supportUser()->attach($objUserTo->user_id, [
                    "row_uuid"    => Util::uuid(),
                    "user_uuid"   => $objUserTo->user_uuid,
                    "ticket_uuid" => $objTicket->ticket_uuid,
                    "flag_office" => true,
                ]);
            }
        } else if ($arrParams["to_type"] == "group") {
            foreach ($arrParams["to"] as $groupTo) {
                $objGroup = $this->authGroupRepository->find($groupTo, true);

                $objTicket->supportGroup()->attach($objGroup->group_id, [
                    "row_uuid"    => Util::uuid(),
                    "group_uuid"  => $objGroup->group_uuid,
                    "ticket_uuid" => $objTicket->ticket_uuid,
                ]);
            }
        } else {
            return (false);
        }

        return (true);
    }

    /**
     * @param SupportTicketModel $ticket
     * @param Collection $users
     * @throws \Exception
     */
    public function attachUsers(SupportTicketModel $ticket, Collection $users) {
        foreach ($users as $user) {
            $objUser = $ticket->supportUser()->find($user->user_id);

            if (isset($objUser)) {
                $ticket->supportUser()->updateExistingPivot($user->user_id, ["flag_active" => true]);
            } else {
                $ticket->supportUser()->attach($user->user_id, [
                    "row_uuid"    => Util::uuid(),
                    "user_uuid"   => $user->user_uuid,
                    "ticket_uuid" => $ticket->ticket_uuid,
                    "flag_active" => true,
                ]);
            }
        }
    }

    /**
     * @param SupportTicketModel $ticket
     * @param Collection $groups
     * @throws \Exception
     */
    public function attachGroup(SupportTicketModel $ticket, Collection $groups) {
        foreach ($groups as $group) {
            $objUser = $ticket->supportGroup()->find($group->group_id);

            if (isset($objUser)) {
                $ticket->supportGroup()->updateExistingPivot($group->group_id, ["flag_active" => true]);
            } else {
                $ticket->supportGroup()->attach($group->group_id, [
                    "row_uuid"    => Util::uuid(),
                    "group_uuid"  => $group->group_uuid,
                    "ticket_uuid" => $ticket->ticket_uuid,
                    "flag_active" => true,
                ]);
            }
        }
    }

    /**
     * @param SupportTicketModel $ticket
     * @param Collection $users
     * @return void
     */
    public function detachUser(SupportTicketModel $ticket, Collection $users): void {
        foreach ($users as $user) {
            $ticket->supportUser()->updateExistingPivot($user->user_id, ["flag_active" => false]);
        }
    }

    /**
     * @param SupportTicketModel $ticket
     * @param AuthGroup $group
     *
     * @return int
     */
    public function detachGroup(SupportTicketModel $ticket, AuthGroup $group): int {
        return ($ticket->supportGroup()->updateExistingPivot($group->group_id, ["flag_active" => false]));
    }
}
