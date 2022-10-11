<?php

namespace App\Jobs\Soundblock\Ledger;

use App\Events\Soundblock\Ledger\ProjectLedger as ProjectLedgerEvent;
use App\Models\Soundblock\Projects\Contracts\Contract;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Users\User;
use App\Services\Soundblock\Contracts\Service as ContractService;
use App\Services\Soundblock\Ledger\ContractLedger as ContractLedgerService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ContractLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Contract
     */
    private Contract $objContract;
    private string $strEvent;
    /**
     * @var User|null
     */
    private ?User $objUser;

    /**
     * Create a new job instance.
     *
     * @param Contract $objContract
     * @param string $strEvent
     * @param User|null $objUser
     * @throws \Exception
     */
    public function __construct(Contract $objContract, string $strEvent, ?User $objUser = null) {
        if (($strEvent === ContractLedgerService::USER_REJECT_ACTION || $strEvent === ContractLedgerService::USER_ACCEPT_ACTION) && is_null($objUser)) {
            throw new \Exception("Invalid Event Payload.");
        }

        $this->objContract = $objContract;
        $this->strEvent = $strEvent;
        $this->objUser = $objUser;
    }

    /**
     * Execute the job.
     *
     * @param ContractLedgerService $contractLedgerService
     * @param ContractService $contractService
     * @return void
     * @throws \Exception
     */
    public function handle(ContractLedgerService $contractLedgerService, ContractService $contractService) {
        $objCreatedBy = $this->objContract->createdBy;
        $str = isset($objCreatedBy->primary_email) ? " <{$objCreatedBy->primary_email->user_auth_email}>" : "";

        switch ($this->strEvent) {
            case ContractLedgerService::NEW_CONTRACT_EVENT:
                /** @var Project $objProject */
                $objProject = $this->objContract->project;

                if (is_null($objProject)) {
                    throw new \Exception("Invalid Project");
                }

                /** @var Account $objAccount */
                $objAccount = $objProject->account;

                if (is_null($objAccount)) {
                    throw new \Exception("Invalid Account");
                }

                $objServiceHolder = $objAccount->user;
                $strHolder = isset($objServiceHolder->primary_email) ? " <{$objServiceHolder->primary_email->user_auth_email}>" : "";

                $arrData = [
                    "Contract ID"                  => $this->objContract->contract_uuid,
                    "Contract Memo"                => "Upon execution of this contract, Soundblock and {$objAccount->account_name} are bound by the terms and conditions available at https://soundblock.com/terms.",
                    "Contract Status"              => strtoupper($this->objContract->flag_status),
                    "Blockchain Account Record ID" => optional($objAccount->ledger)->qldb_id,
                    "Blockchain Project Record ID" => optional($objProject->ledger)->qldb_id,
                    "Account ID"                   => $objAccount->account_uuid,
                    "Account Name"                 => $objAccount->account_name,
                    "Account Owner"                => "$objServiceHolder->name" . $strHolder,
                    "Project ID"                   => $objProject->project_uuid,
                    "Created At"                   => Carbon::parse($this->objContract->stamp_created_at)
                                                            ->format("F j, Y h:i:s A") . " (UTC)",
                    "Created By"                   => "$objCreatedBy->name" . $str,

                ];
                break;
            case ContractLedgerService::CREATING_CONTRACT:
            case ContractLedgerService::NEW_AFTER_VOIDED:
                $arrData = [
                    "Purpose of Update"     => $this->strEvent,
                    "Contract Participants" => $this->getContractUsersInfo($contractService),
                ];

                break;
            case ContractLedgerService::MODIFY_CONTRACT:
                $objUpdated = $this->objContract->updatedBy;

                $arrData = [
                    "Purpose of Update"     => $this->strEvent,
                    "Contract Participants" => $this->getContractUsersInfo($contractService),
                    "Contract Status"       => strtoupper($this->objContract->flag_status),
                    "Updated At"            => Carbon::parse($this->objContract->stamp_updated_at)
                                                     ->format("F j, Y h:i:s A") . " (UTC)",
                    "Updated By"            => "$objUpdated->name <{$objUpdated->primary_email->user_auth_email}>",
                ];
                break;
            case ContractLedgerService::CANCEL_CONTRACT:
            case ContractLedgerService::ACTIVATE_CONTRACT:
                $objUpdated = $this->objContract->updatedBy;

                $arrData = [
                    "Purpose of Update" => $this->strEvent,
                    "Contract Status"   => strtoupper($this->objContract->flag_status),
                    "Updated At"        => Carbon::parse($this->objContract->stamp_updated_at)
                                                 ->format("F j, Y h:i:s A") . " (UTC)",
                    "Updated By"        => "$objUpdated->name <{$objUpdated->primary_email->user_auth_email}>",
                ];
                break;
            case ContractLedgerService::USER_ACCEPT_ACTION:
            case ContractLedgerService::USER_REJECT_ACTION:
                $objUpdated = $this->objContract->updatedBy;
                $str = isset($objUpdated->primary_email) ? " <{$objUpdated->primary_email->user_auth_email}>" : "";
                $strUser = isset($this->objUser->primary_email) ? " <{$this->objUser->primary_email->user_auth_email}>" : "";

                $objUserInfo = $contractService->getContractUserInfo($this->objContract, $this->objUser);

                $arrData = [
                    "Purpose of Update"    => $this->strEvent,
                    "Contract Status"      => strtoupper($this->objContract->flag_status),
                    "Contract Participant" => [
                        "User"            => "{$this->objUser->name}" . $strUser,
                        "User ID"         => $this->objUser->user_uuid,
                        "Contract Status" => $objUserInfo->contract_status,
                    ],
                    "Updated At"           => Carbon::parse($this->objContract->stamp_updated_at)
                                                    ->format("F j, Y h:i:s A") . " (UTC)",
                    "Updated By"           => "$objUpdated->name" . $str,
                ];
                break;
            default:
                throw new \Exception("Invalid Event");
        }

        if (is_null($this->objContract->ledger_id)) {
            $objLedger = $contractLedgerService->createDocument($this->objContract, $arrData, $this->strEvent);

            event(new ProjectLedgerEvent($objProject, $objLedger->ledger_uuid, "contract", $this->objContract->contract_uuid));

        } else {
            $objLedger = $this->objContract->ledger;
            $contractLedgerService->updateDocument($objLedger, $arrData, $this->strEvent);
        }
    }

    private function getContractUsersInfo(ContractService $objContractService) {
        $objContractUsers = $objContractService->getContractMembersByCycle($this->objContract);

        $arrUsers = [];

        foreach ($objContractUsers as $objContractUser) {
            $str = isset($objContractUser->primary_email) ? " <{$objContractUser->primary_email->user_auth_email}>" : "";

            $arrUserData = [
                "User"            => "$objContractUser->name" . $str,
                "User ID"         => $objContractUser->user_uuid,
                "Payout"          => $objContractUser->pivot->user_payout,
                "Contract Status" => "Pending",
            ];

            if (strtolower($objContractUser->pivot->flag_action) === "delete") {
                $arrUserData["Deleting"] = "True";
            }

            $arrUsers[] = $arrUserData;
        }

        return $arrUsers;
    }
}
