<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountingTypeRate extends BaseModel
{
    use HasFactory;

    const UUID = "row_uuid";

    protected $primaryKey = "row_id";

    protected $table = "accounting_types_rates";

    protected $guarded = [];

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", "accounting_type_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];
}
