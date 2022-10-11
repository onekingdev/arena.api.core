<?php

namespace App\Services\Accounting;

use App\Models\Accounting\AccountingTransactionType as AccountingTransactionTypeModel;
use App\Repositories\Accounting\AccountingTransactionType as AccountingTransactionTypeRepository;

class TransactionType {

    /** @var AccountingTransactionTypeRepository */
    protected AccountingTransactionTypeRepository $transactionTypeRepo;

    /**
     * @param AccountingTransactionTypeRepository $transactionTypeRepo
     *
     * @return void
     */
    public function __construct(AccountingTransactionTypeRepository $transactionTypeRepo) {
        $this->transactionTypeRepo = $transactionTypeRepo;
    }

    /**
     * @param string $typeName
     *
     * @return AccountingTransactionTypeModel
     */
    public function findByName(string $typeName): AccountingTransactionTypeModel {
        return ($this->transactionTypeRepo->findByName($typeName));
    }
}
