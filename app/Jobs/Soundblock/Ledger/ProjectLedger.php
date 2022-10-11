<?php

namespace App\Jobs\Soundblock\Ledger;

use App\Events\Soundblock\Ledger\ProjectLedger as ProjectLedgerEvent;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Services\Soundblock\Ledger\ProjectLedger as ProjectLedgerService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProjectLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project
     */
    private Project $objProject;
    private string $strEvent;

    /**
     * Create a new job instance.
     *
     * @param Project $objProject
     * @param string $strEvent
     */
    public function __construct(Project $objProject, string $strEvent) {
        $this->objProject = $objProject;
        $this->strEvent = $strEvent;
    }

    /**
     * Execute the job.
     *
     * @param ProjectLedgerService $projectLedger
     * @return void
     * @throws \Exception
     */
    public function handle(ProjectLedgerService $projectLedger) {
        $objCreatedBy = $this->objProject->createdBy;
        $objUpdatedBy = $this->objProject->updatedBy;

        $strServiceQldbId = null;
        /** @var Account $objAccount */
        $objAccount = $this->objProject->account;

        if (is_null($objAccount)) {
            throw new \Exception("Invalid Project.");
        }

        $objServiceLedger = $objAccount->ledger;

        if (is_object($objServiceLedger)) {
            $strServiceQldbId = $objServiceLedger->qldb_id;
        }

        $arrLedgerData = [
            "Blockchain Account Record ID" => $strServiceQldbId,
            "Project ID"                   => $this->objProject->project_uuid,
            "Account ID"                   => $this->objProject->account_uuid,
            "Account Name"                 => $objAccount->account_name,
            "Project Title"                => $this->objProject->project_title,
            "Project Type"                 => $this->objProject->project_type,
            "Project UPC"                  => $this->objProject->project_upc,
            "Release Date"                 => $this->objProject->project_date,
        ];

        if (is_null($this->objProject->ledger_id)) {
            $str = isset($objCreatedBy->primary_email) ? " <{$objCreatedBy->primary_email->user_auth_email}>" : "";

            $arrLedgerData = array_merge($arrLedgerData, [
                "Created At" => Carbon::parse($this->objProject->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
                "Created By" => "$objCreatedBy->name" . $str,
            ]);

            $objLedger = $projectLedger->createDocument($this->objProject, $arrLedgerData, $this->strEvent);

            event(new ProjectLedgerEvent($this->objProject, $objLedger->ledger_uuid, "project", $this->objProject->project_uuid));
        } else {
            $arrLedgerData = array_merge($arrLedgerData, [
                "Updated At" => Carbon::parse($this->objProject->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
                "Updated By" => "$objUpdatedBy->name <{$objUpdatedBy->primary_email->user_auth_email}>",
            ]);

            $objLedger = $this->objProject->ledger;
            $projectLedger->updateDocument($objLedger, $arrLedgerData, $this->strEvent);
        }
    }
}
