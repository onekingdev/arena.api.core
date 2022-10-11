<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class ServiceLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "services";

    const CREATE_EVENT = "New Service";
    const UPDATE_EVENT = "Update Service Name";
    const STATUS_CHANGE_EVENT = "Service Status Change";
}
