<?php

namespace App\Repositories\Accounting;

use App\Repositories\BaseRepository;
use App\Models\Accounting\AccountingTransactionType as AccountingTransactionTypeModel;

class AccountingTransactionType extends BaseRepository {
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected \Illuminate\Database\Eloquent\Model $model;

    /**
     * @param AccountingTransactionTypeModel $model
     *
     * @return void
     */
    public function __construct(AccountingTransactionTypeModel $model) {
        $this->model = $model;
    }

    /**
     * @param string $typeName
     *
     * @return AccountingTransactionTypeModel
     */
    public function findByName(string $typeName): AccountingTransactionTypeModel {
        return ($this->model->whereRaw("lower(type_name) = (?)", strtolower($typeName))->firstOrFail());
    }

    /**
     * @param string $typeCode
     *
     * @return AccountingTransactionTypeModel
     */
    public function findByCode(string $typeCode): AccountingTransactionTypeModel {
        return ($this->model->where("type_code", $typeCode)->firstOrFail());
    }
}
