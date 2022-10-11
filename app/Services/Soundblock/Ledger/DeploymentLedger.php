<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class DeploymentLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "deployments";

    const NEW_DEPLOYMENT = "New Deployment";
    const TAKE_DOWN = "Take Down";
    const DEPLOYED = "Deployed";
    const FAILED = "Failed";
    const CHANGE_COLLECTION = "Change Collection";
}