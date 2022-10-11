<?php

namespace App\Contracts\Soundblock\Ledger;

use App\Models\{BaseModel, Soundblock\Ledger, Soundblock\LedgerHistory};

interface BaseLedger {
    public function createDocument(BaseModel $model, array $arrData, string $strEvent): Ledger;
    public function updateDocument(Ledger $objLedger, array $arrData, string $strEvent): LedgerHistory;
}