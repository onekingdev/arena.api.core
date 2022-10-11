<?php

namespace App\Jobs\Soundblock\Ledger;

use App\Events\Soundblock\Ledger\ProjectLedger as ProjectLedgerEvent;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Projects\Deployments\Deployment;
use App\Models\Soundblock\Projects\Project;
use App\Services\Soundblock\Ledger\DeploymentLedger as DeploymentLedgerService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeploymentLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Deployment
     */
    private Deployment $objDeployment;
    private string $strEvent;
    private bool $isOffice;

    /**
     * Create a new job instance.
     *
     * @param Deployment $objDeployment
     * @param string $strEvent
     * @param bool $isOffice
     */
    public function __construct(Deployment $objDeployment, string $strEvent, bool $isOffice = false) {
        $this->objDeployment = $objDeployment;
        $this->strEvent = $strEvent;
        $this->isOffice = $isOffice;
    }

    /**
     * Execute the job.
     *
     * @param DeploymentLedgerService $ledgerService
     * @return void
     * @throws \Exception
     */
    public function handle(DeploymentLedgerService $ledgerService) {
        /** @var Project $objProject */
        $objProject = $this->objDeployment->project;

        if (is_null($objProject)) {
            throw new \Exception("Invalid Project.");
        }

        $objAccount = $objProject->account;

        if (is_null($objAccount)) {
            throw new \Exception("Invalid Account.");
        }


        /** @var Collection $objCollection */
        $objCollection = $this->objDeployment->collection;

        if (is_null($objCollection)) {
            throw new \Exception("Invalid Collection.");
        }

        $objCreatedBy = $this->objDeployment->createdBy;

        switch ($this->strEvent) {
            case DeploymentLedgerService::NEW_DEPLOYMENT:
                $arrData = [
                    "Blockchain Account Record ID" => optional($objAccount->ledger)->qldb_id,
                    "Blockchain Project Record ID" => optional($objProject->ledger)->qldb_id,
                    "Account ID"                   => $objAccount->account_uuid,
                    "Project ID"                   => $objProject->project_uuid,
                    "Project Title"                => $objProject->project_title,
                    "Platform Name"                => $this->objDeployment->platform->name,
                    "Collection ID"                => $objCollection->collection_uuid,
                    "Collection Memo"              => $objCollection->collection_comment,
                    "Status"                       => $this->objDeployment->deployment_status,
                    "Tracks"                       => $this->getTracks($objCollection),
                    "Created At"                   => Carbon::parse($this->objDeployment->stamp_created_at)
                                                            ->format("F j, Y h:i:s A") . " (UTC)",
                    "Created By"                   => "$objCreatedBy->name <{$objCreatedBy->primary_email->user_auth_email}>",
                ];

                break;
            case DeploymentLedgerService::TAKE_DOWN:
            case DeploymentLedgerService::DEPLOYED:
            case DeploymentLedgerService::FAILED:
                $objUpdated = $this->objDeployment->updatedBy;
                $arrData = [
                    "Status"          => $this->objDeployment->deployment_status,
                    "Collection ID"   => $objCollection->collection_uuid,
                    "Collection Memo" => $objCollection->collection_comment,
                    "Updated At"      => Carbon::parse($this->objDeployment->stamp_updated_at)
                                               ->format("F j, Y h:i:s A") . " (UTC)",
                    "updated By"      => $this->isOffice ?  "Soundblock" : "$objUpdated->name <{$objUpdated->primary_email->user_auth_email}>",
                ];
                break;
            case DeploymentLedgerService::CHANGE_COLLECTION:
                $arrData = [
                    "Status"          => $this->objDeployment->deployment_status,
                    "Collection ID"   => $objCollection->collection_uuid,
                    "Collection Memo" => $objCollection->collection_comment,
                    "Tracks"          => $this->getTracks($objCollection),
                    "Updated At"      => Carbon::parse($this->objDeployment->stamp_updated_at)
                                               ->format("F j, Y h:i:s A") . " (UTC)",
                    "updated By"      => "Soundblock",
                ];
                break;
            default:
                throw new \Exception("Invalid Event.");
                break;
        }

        if (is_null($this->objDeployment->ledger_id)) {
            $objLedger = $ledgerService->createDocument($this->objDeployment, $arrData, $this->strEvent);

            event(new ProjectLedgerEvent($objProject, $objLedger->ledger_uuid, "deployment", $this->objDeployment->deployment_uuid));
        } else {
            $objLedger = $this->objDeployment->ledger;
            $ledgerService->updateDocument($objLedger, $arrData, $this->strEvent);
        }
    }

    private function getTracks(Collection $objCollection) {
        $arrData = [];
        $objTracks = $objCollection->tracks;

        foreach ($objTracks as $objTrack) {
            $arrData[] = [
                "Track Number" => $objTrack->track_number,
                "Track Name"   => $objTrack->file->file_title,
                "ISRC"         => $objTrack->track_isrc,
            ];
        }

        return $arrData;
    }
}
