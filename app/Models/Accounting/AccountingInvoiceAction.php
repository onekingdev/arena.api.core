<?php

namespace App\Models\Accounting;

use App\Models\BaseModel;
use App\Models\Casts\StampCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountingInvoiceAction extends BaseModel
{
    use HasFactory;

    protected $table = "accounting_invoices_actions";

    protected $guarded = [];

    protected $primaryKey = "row_id";

    protected string $uuid = "row_uuid";

    protected $casts = [
        "response" => "array",
        BaseModel::STAMP_CREATED_BY => StampCast::class,
        BaseModel::STAMP_UPDATED_BY => StampCast::class,
        BaseModel::STAMP_DISCOUNT_BY => StampCast::class,
    ];

    protected $hidden = [
        "invoice_id", "row_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY, BaseModel::DISCOUNT_AT
    ];

    public function invoice(){
        return $this->belongsTo(AccountingInvoice::class);
    }
}
