<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Ledger as LedgerModel;
use App\Models\Soundblock\LedgerHistory as LedgerHistoryModel;

class LedgerHistory extends BaseRepository {
    public function __construct(LedgerHistoryModel $model) {
        $this->model = $model;
    }

    /**
     * @param LedgerModel $objLedger
     * @param array $qldbData
     * @param string $strEvent
     * @return LedgerHistoryModel
     * @throws \Exception
     */
    public function createHistory(LedgerModel $objLedger, array $qldbData, string $strEvent): LedgerHistoryModel {
        return $objLedger->history()->create([
            "row_uuid"      => Util::uuid(),
            "parent_uuid"   => $objLedger->ledger_uuid,
            "qldb_event"    => $strEvent,
            "qldb_id"       => $qldbData["document"]["id"],
            "qldb_block"    => $qldbData["document"]["blockAddress"],
            "qldb_hash"     => $qldbData["document"]["hash"],
            "qldb_data"     => $qldbData["document"],
            "qldb_metadata" => $qldbData["document"]["metadata"],
        ]);
    }
}
