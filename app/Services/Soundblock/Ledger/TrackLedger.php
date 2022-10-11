<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class TrackLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "tracks";

    const CREATE_EVENT = "New Track";
    const UPDATE_EVENT = "Update Track Meta";
}
