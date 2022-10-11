<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class FileLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "files";
}