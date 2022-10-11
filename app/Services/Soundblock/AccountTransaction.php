<?php

namespace App\Services\Soundblock;

use App\Models\{
    Accounting\AccountingType,
    Soundblock\Accounts\Account
};
use App\Repositories\{
    Accounting\AccountingType as AccountingTypeRepository,
    Soundblock\AccountTransaction as AccountTransactionRepository
};
use App\Models\Soundblock\Accounts\AccountTransaction as AccountTransactionModel;

class AccountTransaction {
    /** @var AccountTransactionRepository */
    protected AccountTransactionRepository $accountTransactionRepo;
    /** @var AccountingTypeRepository */
    protected AccountingTypeRepository $accountingTypeRepo;

    public function __construct(AccountTransactionRepository $accountTransactionRepo, AccountingTypeRepository $accountingTypeRepo) {
        $this->accountingTypeRepo     = $accountingTypeRepo;
        $this->accountTransactionRepo = $accountTransactionRepo;
    }
}
