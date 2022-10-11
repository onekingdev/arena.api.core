<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountingType extends BaseModel
{
    use HasFactory;

    const UUID = "accounting_type_uuid";

    protected $guarded = [];

    protected $primaryKey = "accounting_type_id";

    protected string $uuid = "accounting_type_uuid";

    protected $hidden = [
        "accounting_type_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function accountingTypeRates() {
        return $this->hasMany(AccountingTypeRate::class, "accounting_type_id", "accounting_type_id");
    }
}
