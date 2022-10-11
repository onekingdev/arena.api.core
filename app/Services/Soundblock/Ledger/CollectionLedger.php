<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class CollectionLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "collections";
    const CREATE_EVENT = "Create Collection";
    const UPDATE_EVENT = "Update Collection";
}