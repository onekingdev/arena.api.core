<?php

namespace App\Services\Office;

use Util;
use Auth;
use Client;
use Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\Core\Support\TicketReply;
use App\Models\Users\User as UserModel;
use App\Models\Support\Ticket\SupportTicket;
use App\Mail\System\Notification\Ticket as TicketMail;
use App\Services\Common\{Zip, Office, App as AppService};
use App\Events\{Common\PrivateNotification, Common\UpdateSupportTicket, Office\Support\TicketAttach};
use App\Repositories\{
    Office\SupportTicketMessage as SupportTicketMessageRepository,
    Office\SupportTicket as SupportTicketRepository,
    User\User
};

class SupportTicketMessage {
    protected User $userRepo;
    protected SupportTicketMessageRepository $msgRepo;
    protected SupportTicketRepository $ticketRepo;
    protected Office $officeService;
    /** @var \App\Services\Common\App */
    private AppService $appService;

    /**
     * SupportTicketMessage constructor.
     * @param \App\Repositories\Office\SupportTicketMessage $msgRepo
     * @param \App\Repositories\Office\SupportTicket $ticketRepo
     * @param \App\Repositories\User\User $userRepo
     * @param \App\Services\Common\Office $officeService
     * @param \App\Services\Common\App $appService
     */
    public function __construct(SupportTicketMessageRepository $msgRepo, SupportTicketRepository $ticketRepo,
                                User $userRepo, Office $officeService, AppService $appService) {
        $this->msgRepo = $msgRepo;
        $this->ticketRepo = $ticketRepo;
        $this->userRepo = $userRepo;
        $this->officeService = $officeService;
        $this->appService = $appService;
    }

    public function getMessages(array $arrParams, SupportTicket $ticket, int $perPage = 10, bool $withoutOffice = false, bool $flagOffice = false) {
        [$objMessages, $availableMetaData] = $this->msgRepo->getMessages($arrParams, $ticket, $perPage, $withoutOffice);

        if (!$flagOffice) {
            foreach ($objMessages as $objMessage) {
                $objMessage->update(["flag_status" => "Read"]);
            }
        }

        return ([$objMessages, $availableMetaData]);
    }

    public function getUserUnreadMessages($objUser){
        return ($this->msgRepo->getUserUnreadMessages($objUser->user_uuid));
    }

    public function create(bool $bnOffice, array $arrParams, bool $bnInCreation = false) {
        $arrTicketMsg = [];
        $objApp = Client::app();

        if ($arrParams["ticket"] instanceof SupportTicket) {
            $objTicket = $arrParams["ticket"];
        } else {
            $objTicket = $this->ticketRepo->find($arrParams["ticket"], true);
        }

        if (isset($arrParams["user"])) {
            if ($arrParams["user"] instanceof UserModel) {
                $objUser = $arrParams["user"];
            } else {
                $objUser = $this->userRepo->find($arrParams["user"], true);
            }
        } else {
            $objUser = Auth::user();
        }

        $arrTicketMsg["ticket_id"] = $objTicket->ticket_id;
        $arrTicketMsg["ticket_uuid"] = $objTicket->ticket_uuid;
        $arrTicketMsg["user_id"] = $objUser->user_id;
        $arrTicketMsg["user_uuid"] = $objUser->user_uuid;
        $arrTicketMsg["message_text"] = $arrParams["message_text"];
        $arrTicketMsg["flag_office"] = $bnOffice;
        $arrTicketMsg["flag_notified"] = false; // default
        $arrTicketMsg["flag_status"] = "Unread";

        if ($bnOffice) {
            $arrTicketMsg["flag_officeonly"] = $arrParams["flag_officeonly"];
        } else {
            $arrTicketMsg["flag_officeonly"] = false;
        }

        if (isset($arrParams["files"])) {
            $arrTicketMsg["flag_attachments"] = true;
            $objMsg = $this->msgRepo->create($arrTicketMsg);
            $arrMeta = $this->upload($objMsg->ticket, $arrParams["files"]);

            event(new TicketAttach($objMsg, $arrMeta));
        } else {
            $arrTicketMsg["flag_attachments"] = false;
            $objMsg = $this->msgRepo->create($arrTicketMsg);
        }

        $objTicket->update([
            "flag_status" => $bnOffice ? "Awaiting Customer" : "Awaiting Support"
        ]);

        event(new UpdateSupportTicket($objTicket, $bnOffice ? "soundblock" : "office"));
        $objSupport = $objTicket->support;
        $objSupportApp = $objSupport->app;

        if ($bnOffice && !$arrTicketMsg["flag_officeonly"] && !$bnInCreation) {
            $arrMsg = [
                "notification_name" => ucfirst($objSupportApp->app_name),
                "notification_memo" => "Support Ticket Reply",
                "ticket_message"    => $arrParams["message_text"],
                "autoClose"         => true,
                "showTime"          => 5000,
            ];

            if (ucfirst($objSupportApp->app_name) == "Soundblock") {
                $arrMsg["ticket_url"] = app_url($objSupportApp->app_name) . "support?ticket_id=" . $objTicket->ticket_uuid;
            }

            $flags = [
                "notification_state" => "unread",
                "flag_canarchive"    => true,
                "flag_candelete"     => true,
                "flag_email"         => false,
            ];

            event(new PrivateNotification($objTicket->user, $arrMsg, $flags, $objApp));
        } else {
            $strAppName = ucfirst($objSupportApp->app_name);
            $strMemo = "&quot;{$objTicket->ticket_title}&quot; by {$objUser->name} <br> {$strAppName} &bull; {$objTicket->support->support_category}";
            $strUrl = app_url("office") . "customers/support/tickets/" . $objTicket->ticket_uuid;
            $objOfficeApp = $this->appService->findOneByName("office");

            notify_group("App.Office.Support", $objOfficeApp, "Support Ticket Reply", $strMemo, Builder::notification_link([
                "link_name" => "View Ticket",
                "url"       => $strUrl,
            ]), $strUrl);
        }

        if (!$bnInCreation) {
            $arrMailTo = ["swhite@arena.com"];

            if (config("app.env") === "prod") {
                $arrMailTo = ["ajohnson@soundblock.com", "swhite@arena.com"];
            }

            Mail::to($arrMailTo)->send(new TicketMail($objTicket, "Support Ticket Reply", $objMsg, "Support Ticket Reply ({$objTicket->ticket_title})"));
        }

        if ($objApp->app_name == "office") {
            Mail::to($objTicket->user->primary_email->user_auth_email)->send(new TicketReply($objTicket));
        }

        return ($objMsg);
    }

    public function upload(SupportTicket $objTicket, array $files): array {
        $arrMeta = [];

        foreach ($files as $file) {
            $meta = [];
            $path = Util::ticket_path($objTicket);
            $meta["attachment_url"] = $this->officeService->putFile($file, $path);
            $meta["attachment_name"] = $file->getClientOriginalName();

            array_push($arrMeta, $meta);
        }

        return ($arrMeta);
    }
}
