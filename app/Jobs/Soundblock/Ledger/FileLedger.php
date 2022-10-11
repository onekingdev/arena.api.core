<?php

namespace App\Jobs\Soundblock\Ledger;

use App\Events\Soundblock\Ledger\ProjectLedger as ProjectLedgerEvent;
use App\Models\Soundblock\Collections\Collection;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\Soundblock\Files\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Soundblock\File as FileService;
use App\Services\Soundblock\Ledger\FileLedger as FileLedgerService;

class FileLedger implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const ALGOS = ["sha256", "sha3-512", "whirlpool", "tiger192,4", "crc32c", "fnv1a64", "haval256,5"];
    public int $timeout = 3600;
    /**
     * @var File
     */
    private File $objFile;
    private string $strFilePath;

    /**
     * Create a new job instance.
     *
     * @param File $objFile
     * @param string $strFilePath
     */
    public function __construct(File $objFile, string $strFilePath) {
        $this->objFile = $objFile;
        $this->strFilePath = $strFilePath;
    }

    /**
     * Execute the job.
     *
     * @param FileLedgerService $ledgerService
     * @param FileService $fileService
     * @return void
     * @throws \Exception
     */
    public function handle(FileLedgerService $ledgerService, FileService $fileService) {
        if (app()->environment("testing")) {
            return;
        }

        /** @var Collection $objCollection */
        $objCollection = $this->objFile->collections()->first();

        if (is_null($objCollection)) {
            throw new \Exception("Invalid Collection.");
        }

        $objProject = $objCollection->project;

        if (is_null($objProject)) {
            throw new \Exception("Invalid Project.");
        }

        $objCreatedBy = $this->objFile->createdBy;
        $objHistory = $fileService->getLatestFileHistory($this->objFile);

        $hashes = [];

        $arrFileData = [
            "File ID"    => $this->objFile->file_uuid,
            "Filename"   => $this->objFile->file_name,
            "Title"      => $this->objFile->file_title,
            "Action"     => $objHistory->file_action,
            "File Data"  => $this->objFile->meta_ledger,
            "Created At" => Carbon::parse($this->objFile->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
            "Created By" => "$objCreatedBy->name <{$objCreatedBy->primary_email->user_auth_email}>",
        ];

        $objLedger = $this->objFile->ledger;

        if (is_null($objLedger)) {
            $fileContent = bucket_storage("soundblock")->temporaryUrl($this->strFilePath, now()->addMinutes(10));

            foreach (self::ALGOS as $algo) {
                try {
                    $hashes[$algo] = hash_file($algo, $fileContent);
                } catch (\Exception $exception) {
                    $hashes[$algo] = null;
                }
            }

            $arrFileData = array_merge($hashes, $arrFileData, [
                "Path"     => $this->objFile->file_path,
                "Category" => $this->objFile->file_category,
                "Size"     => $this->objFile->file_size,
                "MD5"      => $this->objFile->file_md5,
            ]);

            $ledgerService->createDocument($this->objFile, $arrFileData, strtolower($objHistory->file_action));

            event(new ProjectLedgerEvent($objProject, $objLedger->ledger_uuid, "file", $this->objFile->file_uuid));
        } else {
            $ledgerService->updateDocument($objLedger, $arrFileData, strtolower($objHistory->file_action));
        }
    }
}
