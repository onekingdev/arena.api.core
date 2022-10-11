<?php

namespace App\Jobs\Soundblock\Ledger;

use App\Events\Soundblock\Ledger\ProjectLedger as ProjectLedgerEvent;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Services\Soundblock\Collection as CollectionService;
use App\Services\Soundblock\File as FileService;
use App\Services\Soundblock\Ledger\CollectionLedger as CollectionLedgerService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CollectionLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection
     */
    private Collection $collection;
    private string $strEvent;
    private array $filesChanges;

    /**
     * Create a new job instance.
     *
     * @param Collection $collection
     * @param string $strEvent
     * @param array $filesChanges
     */
    public function __construct(Collection $collection, string $strEvent, array $filesChanges = []) {
        $this->collection = $collection;
        $this->strEvent = $strEvent;
        $this->filesChanges = $filesChanges;
    }

    /**
     * Execute the job.
     *
     * @param CollectionLedgerService $collectionLedgerService
     * @param FileService $fileService
     * @param CollectionService $collectionService
     * @return void
     * @throws \Exception
     */
    public function handle(CollectionLedgerService $collectionLedgerService, FileService $fileService, CollectionService $collectionService) {
        $strProjectQldb = null;
        $strServiceQldb = null;

        $objCreatedBy = $this->collection->createdBy;

        /** @var Project $objProject */
        $objProject = $this->collection->project;

        if (is_null($objProject)) {
            throw new \Exception("Invalid Project.");
        }

        $objProjectLedger = $objProject->ledger;

        if (is_object($objProjectLedger)) {
            $strProjectQldb = $objProjectLedger->qldb_id;
        }

        /** @var Account $objAccount */
        $objAccount = $objProject->account;

        if (is_null($objAccount)) {
            throw new \Exception("Invalid Account.");
        }

        $objServiceLedger = $objAccount->ledger;

        if (is_object($objServiceLedger)) {
            $strServiceQldb = $objServiceLedger->qldb_id;
        }
        $str = isset($objCreatedBy->primary_email) ? " <{$objCreatedBy->primary_email->user_auth_email}>" : "";

        $arrData = [
            "Blockchain Account Record ID" => $strServiceQldb,
            "Blockchain Project Record ID" => $strProjectQldb,
            "Account ID"                   => $objAccount->account_uuid,
            "Account Name"                 => $objAccount->account_name,
            "Project ID"                   => $objProject->project_uuid,
            "Project Title"                => $objProject->project_title,
            "Collection ID"                => $this->collection->collection_uuid,
            "Collection Memo"              => $this->collection->collection_comment,
            "Categories Changed"           => [
                "Music" => strval($this->collection->flag_changed_music),
                "Video" => strval($this->collection->flag_changed_video),
                "Merch" => strval($this->collection->flag_changed_merchandising),
                "Files" => strval($this->collection->flag_changed_other),
            ],
            "Created At"                   => Carbon::parse($this->collection->stamp_created_at)
                                                    ->format("F j, Y h:i:s A") . " (UTC)",
            "Created By"                   => "$objCreatedBy->name" . $str,
        ];

        $arrFiles = [];

        foreach ($this->collection->files as $objFile) {
            $objFileCreated = $objFile->createdBy;
            $objHistory = $fileService->getLatestFileHistory($objFile);

            $filestr = isset($objFileCreated->primary_email) ? " <{$objFileCreated->primary_email->user_auth_email}>" : "";

            $arrFileData = [
                "Blockchain File Record ID" => optional($objFile->ledger)->qldb_id,
                "File ID"    => $objFile->file_uuid,
                "Path"       => $objFile->file_path,
                "Filename"   => $objFile->file_name,
                "Title"      => $objFile->file_title,
                "Category"   => $objFile->file_category,
                "Action"     => is_null($objHistory) ? "Created" : $objHistory->file_action,
                "Size"       => $objFile->file_size,
                "MD5"        => $objFile->file_md5,
                "Created At" => Carbon::parse($objFile->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
                "Created By" => "$objFileCreated->name" . $filestr,
            ];

            if (!empty($this->filesChanges["changes"]) && isset($this->filesChanges["changes"][$objFile->file_uuid])) {
                $arrFileData["Changes"] = $this->filesChanges["changes"][$objFile->file_uuid];
            }

            $arrFiles[] = $arrFileData;
        }

        if (!empty($this->filesChanges["deleted"])) {
            $arrDeletedFiles = [];

            foreach ($this->filesChanges["deleted"] as $objDeletedFile) {
                $arrDeletedFiles[] = [
                    "File ID"    => $objDeletedFile->file_uuid,
                    "Path"       => $objDeletedFile->file_path,
                    "Filename"   => $objDeletedFile->file_name,
                    "Title"      => $objDeletedFile->file_title,
                    "Category"   => $objDeletedFile->file_category,
                    "Size"       => $objDeletedFile->file_size,
                ];
            }

            $arrData["Deleted files"] = $arrDeletedFiles;
        }

        $arrData["Files"] = $arrFiles;

        if (is_null($this->collection->ledger_id)) {
            $objLedger = $collectionLedgerService->createDocument($this->collection, $arrData, CollectionLedgerService::CREATE_EVENT);

            event(new ProjectLedgerEvent($objProject, $objLedger->ledger_uuid, "collection", $this->collection->collection_uuid));
        } else {
            $objCollectionLedger = $this->collection->ledger;
            $collectionLedgerService->updateDocument($objCollectionLedger, $arrData, CollectionLedgerService::UPDATE_EVENT);
        }

    }
}
