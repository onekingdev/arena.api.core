<?php

namespace App\Services\Common;

use App\Models\Accounting\AccountingType as AccountingTypeModel;
use App\Repositories\Accounting\AccountingType as AccountingTypeRepository;

class AccountingType {

    /** @var AccountingTypeRepository */
    protected AccountingTypeRepository $accountingTypeRepo;

    /**
     * @param AccountingTypeRepository $accountingTypeRepo
     *
     * @return void
     */
    public function __construct(AccountingTypeRepository $accountingTypeRepo) {
        $this->accountingTypeRepo = $accountingTypeRepo;
    }

    /**
     * @param string $accountingTypeName
     *
     * @return AccountingTypeModel
     */
    public function findByName(string $accountingTypeName): AccountingTypeModel {
        return ($this->accountingTypeRepo->findByName($accountingTypeName));
    }
}
