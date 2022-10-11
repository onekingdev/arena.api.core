<?php

namespace App\Services\Soundblock\Ledger;

use App\Contracts\Soundblock\Ledger\BaseLedger;
use App\Services\Soundblock\Ledger\BaseLedger as BaseLedgerService;

class ContractLedger extends BaseLedgerService implements BaseLedger {
    const QLDB_TABLE = "contracts";

    const NEW_CONTRACT_EVENT = "New Contract";
    const CREATING_CONTRACT = "Creating New Contract";
    const USER_ACCEPT_ACTION = "User Accepts Contract";
    const USER_REJECT_ACTION = "User Reject Contract";
    const MODIFY_CONTRACT = "Modify Contract";
    const CANCEL_CONTRACT = "Cancel Contract";
    const NEW_AFTER_VOIDED = "New Contract after Cancel/Rejection";
    const ACTIVATE_CONTRACT = "Contract Activated";
}