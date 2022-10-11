<?php

namespace App\Repositories\Office;

use Util;
use Carbon\Carbon;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\{Support\Ticket\SupportTicket as SupportTicketModel, Users\User};

class SupportTicket extends BaseRepository {
    
    /**
     * @param SupportTicketModel $objTicket
     * @return void
     */
    public function __construct(SupportTicketModel $objTicket) {
        $this->model = $objTicket;
    }

    /**
     * @param array $arrParams
     * @param int|null $perPage
     * @param array|null $groups
     * @param User|null $objUser
     * @return array
     */
    public function findAll(array $arrParams, int $perPage = null, ?array $groups = null, ?User $objUser = null) {
        $query = $this->model->join("support", "support_tickets.support_id", "=", "support.support_id")
            ->join("core_apps", "support.app_id", "=", "core_apps.app_id")
            ->with(["support", "supportUser", "supportGroup", "support.app"])
            ->where(function ($where) use ($groups, $objUser) {
                $userCheckMethod = "whereHas";

                if(isset($groups)) {
                    $userCheckMethod = "orWhereHas";

                    $where = $where->whereHas("supportGroup", function (Builder $query) use ($groups) {
                        $query->whereIn('core_auth_groups.group_id', $groups);
                    });
                }

                if(isset($objUser)) {
                    $where = $where->{$userCheckMethod}("supportUser", function (Builder $query) use ($objUser) {
                        $query->where('users.user_id', $objUser->user_id);
                    });
                }
            })->select("support_tickets.*");


        [$objTickets, $availableMetaData] = $this->applyFilter($query, $arrParams, $perPage);

        return ([$objTickets, $availableMetaData]);
    }

    /**
     * @param array $arrParams
     * @param int|null $perPage
     * @return \Illuminate\Database\Eloquent\Collection|LengthAwarePaginator
     */
    public function findAllForOffice(array $arrParams, ?int $perPage = null){
        $query = $this->model->join("support", "support_tickets.support_id", "=", "support.support_id")
            ->join("core_apps", "support.app_id", "=", "core_apps.app_id")
            ->with(["support", "support.app"])
            ->select("support_tickets.*");

        [$objTickets, $availableMetaData] = $this->applyFilter($query, $arrParams, $perPage);

        return ($objTickets);
    }

    public function checkTicketUserForCore(User $objUser, string $ticket){
        return ($this->model->where("ticket_uuid", $ticket)->where(function ($where) use ($objUser) {
            $where->where("support_tickets.user_id", $objUser->user_id)
                ->orWhereHas("supportUser", function (Builder $query) use ($objUser) {
                    $query->where('users.user_id', $objUser->user_id);
                });
        })->first());
    }

    public function checkTicketDuplicate(string $user_uuid, string $title){
        return (
            $this->model->where("user_uuid", $user_uuid)
                ->whereRaw("lower(ticket_title) = (?)", Util::lowerLabel($title))
            ->exists()
        );
    }

    /**
     * @param Builder $query
     * @param array $arrParams
     * @param int|null $perPage
     * @return array
     */
    protected function applyFilter(Builder $query, array $arrParams, ?int $perPage = null) {
        $query = $query->orderBy("support_tickets.stamp_created_at", "desc");

        if(isset($arrParams["sort"])) {
            $query = $query->orderBy("support_tickets.stamp_created_at", Util::lowerLabel($arrParams["sort"]));
        }

        if(isset($arrParams["sort_app"])) {
            $query = $query->orderBy("core_apps.app_name", Util::lowerLabel($arrParams["sort_app"]));
        }

        if(isset($arrParams["sort_support_category"])) {
            $query = $query->orderBy("support.support_category", Util::lowerLabel($arrParams["sort_support_category"]));
        }

        if(isset($arrParams["sort_flag_status"])) {
            $query = $query->orderBy("flag_status", Util::lowerLabel($arrParams["sort_flag_status"]));
        }

        if(isset($arrParams["flag_status"])) {
            $query = $query->whereRaw("lower(support_tickets.flag_status) = (?)", Util::lowerLabel($arrParams["flag_status"]));
        } else {
            $query = $query->where("support_tickets.flag_status", "!=", "Closed");
        }

        if(isset($arrParams["support_category"])) {
            $query = $query->whereRaw("lower(support.support_category) = (?)", Util::lowerLabel($arrParams["support_category"]));
        }

        if(isset($arrParams["app"])) {
            $query = $query->where("core_apps.app_uuid", $arrParams["app"]);
        }

        if(isset($arrParams["date_start"])) {
            $arrParams["date_start"] = Carbon::parse($arrParams["date_start"])->format("Y-m-d H:i");
            $query = $query->where("support_tickets.stamp_created_at", ">=", $arrParams["date_start"]);
        }

        if(isset($arrParams["date_end"])) {
            $arrParams["date_end"] = Carbon::parse($arrParams["date_start"])->format("Y-m-d H:i");
            $query = $query->where("support_tickets.stamp_created_at", "<=", $arrParams["date_end"]);
        }

        if(isset($arrParams["users"])) {
            $query = $query->whereHas("supportUser", function (Builder $query) use ($arrParams) {
                $query->whereIn("users.user_uuid", $arrParams["users"]);
            });
        }

        if(isset($arrParams["groups"])) {
            $query = $query->whereHas("supportGroup", function (Builder $query) use ($arrParams) {
                $query->whereIn("core_auth_groups.group_uuid", $arrParams["groups"]);
            });
        }

        [$query, $availableMetaData] = $this->applyMetaFilters($arrParams, $query);

        if(isset($perPage)) {
            $arrTickets = $query->paginate($perPage);
        } else {
            $arrTickets = $query->get();
        }

        return ([$arrTickets, $availableMetaData]);
    }
}
