<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class ProjectLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "projects";

    const CREATE_EVENT = "Create Project";
    const UPDATE_EVENT = "Edit Project";
}