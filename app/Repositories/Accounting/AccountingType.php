<?php

namespace App\Repositories\Accounting;

use App\Repositories\BaseRepository;
use App\Models\Accounting\AccountingType as AccountingTypeModel;

class AccountingType extends BaseRepository {
    /**
     * AccountingTypeRepository constructor.
     * @param AccountingTypeModel $accountingType
     */
    public function __construct(AccountingTypeModel $accountingType) {
        $this->model = $accountingType;
    }

    public function findByName(string $accountingTypeName): ?AccountingTypeModel {
        return $this->model->whereRaw("lower(accounting_type_name) = ?", strtolower($accountingTypeName))->first();
    }

    public function addNewType(array $insertData){
        return ($this->model->create($insertData));
    }

    public function updateType(array $requestData, string $typeUuid){
        return ($this->model->where("accounting_type_uuid", $typeUuid)->update($requestData));
    }

    public function deleteType(string $typeUuid){
        return ($this->model->where("accounting_type_uuid", $typeUuid)->delete());
    }
}
