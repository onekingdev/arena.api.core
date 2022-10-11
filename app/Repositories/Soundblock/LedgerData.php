<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Soundblock\Ledger as LedgerModel;
use App\Models\Soundblock\LedgerData as LedgerDataModel;

class LedgerData extends BaseRepository {
    public function __construct(LedgerDataModel $model) {
        $this->model = $model;
    }

    /**
     * @param LedgerModel $objLedger
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function saveLedgerData(LedgerModel $objLedger, array $data): \Illuminate\Database\Eloquent\Model
    {
        return (
            $objLedger->metadata()->create([
                "data_uuid"   => Util::uuid(),
                "ledger_uuid" => $objLedger->ledger_uuid,
                "data_json"   => $data,
            ])
        );
    }
}
