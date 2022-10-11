<?php

namespace App\Repositories\Accounting;

use App\Repositories\BaseRepository;
use App\Models\Accounting\AccountingInvoiceType as AccountingInvoiceTypeModel;

class AccountingInvoiceType extends BaseRepository {
    protected \Illuminate\Database\Eloquent\Model $model;

    /**
     * @param AccountingInvoiceTypeModel $model
     *
     * @return void
     */
    public function __construct(AccountingInvoiceTypeModel $model) {
        $this->model = $model;
    }

    /**
     * @param string $typeCode
     *
     * @return AccountingInvoiceTypeModel
     */
    public function findByCode(string $typeCode): AccountingInvoiceTypeModel {
        return ($this->model->where("type_code", $typeCode)->firstOrFail());
    }

    public function findByName(string $typeName): AccountingInvoiceTypeModel {
        return ($this->model->whereRaw("lower(type_name) = (?)", strtolower($typeName))->firstOrFail());
    }
}
