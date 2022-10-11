<?php

namespace App\Jobs\Soundblock\Ledger;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Soundblock\Accounts\Account;
use App\Services\Soundblock\Ledger\ServiceLedger as LedgerService;

class ServiceLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Account
     */
    private Account $objAccount;
    private string $strEvent;

    /**
     * Create a new job instance.
     *
     * @param Account $objAccount
     * @param string $strEvent
     */
    public function __construct(Account $objAccount, string $strEvent) {
        $this->objAccount = $objAccount;
        $this->strEvent = $strEvent;
    }

    /**
     * Execute the job.
     *
     * @param LedgerService $ledgerService
     * @return void
     * @throws \Exception
     */
    public function handle(LedgerService $ledgerService) {
        $objCreatedBy = $this->objAccount->createdBy;
        $objUpdatedBy = $this->objAccount->updatedBy;

        switch ($this->strEvent) {
            case LedgerService::CREATE_EVENT:
                $arrLedgerData = [
                    "Account ID"     => $this->objAccount->account_uuid,
                    "Account Name"   => $this->objAccount->account_name,
                    "Account Status" => $this->objAccount->flag_status,
                    "User Uuid"      => $this->objAccount->user_uuid,
                    "User Name"      => $this->objAccount->user->name,
                    "Created At"     => Carbon::parse($this->objAccount->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
                    "Created By"     => "$objCreatedBy->name <{$objCreatedBy->primary_email->user_auth_email}>",
                ];
                break;
            case LedgerService::UPDATE_EVENT:
                $arrLedgerData = [
                    "Account ID"   => $this->objAccount->account_uuid,
                    "Account Name" => $this->objAccount->account_name,
                    "User Uuid"    => $this->objAccount->user_uuid,
                    "User Name"    => $this->objAccount->user->name,
                    "Updated At"   => Carbon::parse($this->objAccount->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
                    "Updated By"   => "$objUpdatedBy->name <{$objUpdatedBy->primary_email->user_auth_email}>",
                ];

                break;
            case LedgerService::STATUS_CHANGE_EVENT:
                $arrLedgerData = [
                    "Account ID"     => $this->objAccount->account_uuid,
                    "Account Name"   => $this->objAccount->account_name,
                    "Account Status" => $this->objAccount->flag_status,
                    "User Uuid"      => $this->objAccount->user_uuid,
                    "User Name"      => $this->objAccount->user->name,
                    "Updated At"   => Carbon::parse($this->objAccount->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
                    "Updated By"   => "$objUpdatedBy->name <{$objUpdatedBy->primary_email->user_auth_email}>",
                ];

                break;
        }


        if (is_null($this->objAccount->ledger_id)) {
            $ledgerService->createDocument($this->objAccount, $arrLedgerData, LedgerService::CREATE_EVENT);

            event(new \App\Events\Soundblock\Ledger\ServiceLedger($this->objAccount));
        } else {
            $objLedger = $this->objAccount->ledger;
            $ledgerService->updateDocument($objLedger, $arrLedgerData, LedgerService::UPDATE_EVENT);
        }
    }
}
