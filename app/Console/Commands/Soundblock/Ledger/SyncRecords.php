<?php

namespace App\Console\Commands\Soundblock\Ledger;

use Illuminate\Console\Command;
use App\Contracts\Soundblock\Ledger;
use App\Repositories\Soundblock\Ledger as LedgerRepository;

class SyncRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "ledger:sync";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command is made for sync ledger records after python service goes down.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param LedgerRepository $ledgerRepo
     * @param Ledger $ledgerService
     * @return int
     */
    public function handle(LedgerRepository $ledgerRepo, Ledger $ledgerService)
    {
        /* Get records for sync from soundblock_ledger table */
        $objLedgerForSync = $ledgerRepo->getRecordsForSync();

        foreach ($objLedgerForSync as $objLedger) {
            /* Prepare data to send to qldb */
            $arrData = $objLedger->metadata()->value("data_json");

            if (!empty($arrData)) {
                /* Insert qldb record */
                $arrInsertedData = $ledgerService->insertDocument($objLedger->qldb_table, array_merge([
                    "Blockchain Ledger ID" => $objLedger->ledger_uuid,
                ], $arrData));

                /* Update soundblock_ledger table with qldb response */
                $objLedger->update([
                    "qldb_id"       => $arrInsertedData["document"]["id"],
                    "qldb_block"    => $arrInsertedData["document"]["blockAddress"],
                    "qldb_hash"     => $arrInsertedData["document"]["hash"],
                    "qldb_metadata" => $arrInsertedData["document"]["metadata"],
                    "qldb_data"     => $arrInsertedData["document"],
                ]);
            }
        }

        return 0;
    }
}
