<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger;
use Util;
use App\Models\BaseModel;
use App\Models\Soundblock\Ledger as LedgerModel;
use App\Models\Soundblock\LedgerHistory as LedgerHistoryModel;
use App\Repositories\Soundblock\Ledger as LedgerRepository;
use App\Repositories\Soundblock\LedgerHistory as LedgerHistoryRepo;
use App\Repositories\Soundblock\LedgerData as LedgerDataRepository;

abstract class BaseLedger {
    /**
     * @var Ledger
     */
    private Ledger $ledgerService;
    /**
     * @var LedgerRepository
     */
    private LedgerRepository $ledgerRepo;
    /**
     * @var LedgerHistoryRepo
     */
    private LedgerHistoryRepo $ledgerHistoryRepo;
    /**
     * @var LedgerDataRepository
     */
    private LedgerDataRepository $ledgerDataRepo;

    /**
     * BaseLedger constructor.
     * @param Ledger $ledgerService
     * @param LedgerRepository $ledgerRepo
     * @param LedgerHistoryRepo $ledgerHistoryRepo
     * @param LedgerDataRepository $ledgerDataRepo
     */
    public function __construct(Ledger $ledgerService, LedgerRepository $ledgerRepo, LedgerHistoryRepo $ledgerHistoryRepo,
                                LedgerDataRepository $ledgerDataRepo) {
        $this->ledgerService = $ledgerService;
        $this->ledgerRepo = $ledgerRepo;
        $this->ledgerHistoryRepo = $ledgerHistoryRepo;
        $this->ledgerDataRepo = $ledgerDataRepo;
    }

    /**
     * @param BaseModel $model
     * @param array $arrData
     * @param string $strEvent
     * @return LedgerModel
     * @throws \Exception
     */
    public function createDocument(BaseModel $model, array $arrData, string $strEvent): LedgerModel {
        $objLedger = $this->ledgerRepo->create([
            "ledger_uuid" => Util::uuid(),
            "qldb_table"  => static::QLDB_TABLE,
            "qldb_event"  => $strEvent,
            "table_name"  => $model->getTable(),
            "table_field" => $model->getKeyName(),
            "table_id"    => $model->getKey(),
        ]);

        if (is_null($objLedger->metadata)) {
            $this->ledgerDataRepo->saveLedgerData($objLedger, $arrData);
        }

        $arrInsertedData = $this->ledgerService->insertDocument(static::QLDB_TABLE, array_merge([
            "Blockchain Ledger ID" => $objLedger->ledger_uuid,
        ], $arrData));

        $objLedger->update([
            "qldb_id"       => $arrInsertedData["document"]["id"],
            "qldb_block"    => $arrInsertedData["document"]["blockAddress"],
            "qldb_hash"     => $arrInsertedData["document"]["hash"],
            "qldb_metadata" => $arrInsertedData["document"]["metadata"],
            "qldb_data"     => $arrInsertedData["document"],
        ]);

        $model->ledger_id = $objLedger->ledger_id;
        $model->ledger_uuid = $objLedger->ledger_uuid;
        $model->save();

        return $objLedger;
    }

    /**
     * @param LedgerModel $objLedger
     * @param array $arrData
     * @param string $strEvent
     * @return LedgerHistoryModel
     * @throws \Exception
     */
    public function updateDocument(LedgerModel $objLedger, array $arrData, string $strEvent): LedgerHistoryModel {
        $arrInsertedData = $this->ledgerService->updateDocument(static::QLDB_TABLE, $objLedger->qldb_id, $arrData);

        return $this->ledgerHistoryRepo->createHistory($objLedger, $arrInsertedData, $strEvent);
    }
}
