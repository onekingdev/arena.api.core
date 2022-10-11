<?php

namespace App\Models\Soundblock\Accounts;

use App\Models\{BaseModel,
    Casts\StampCast,
    Soundblock\Ledger,
    Accounting\AccountingInvoice,
    Accounting\AccountingTransaction,
    Accounting\AccountingInvoiceTransaction};
use App\Models\Accounting\AccountingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountInvoice extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_accounts_invoices";

    protected $primaryKey = "invoice_id";

    protected string $uuid = "invoice_uuid";

    protected $guarded = [];

    protected $hidden = [
        "invoice_id", "transaction_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    protected $casts = [
        "response" => "array",
        BaseModel::STAMP_CREATED_BY => StampCast::class,
        BaseModel::STAMP_UPDATED_BY => StampCast::class,
        BaseModel::STAMP_DISCOUNT_BY => StampCast::class,
    ];

    public function transactions()
    {
        return ($this->belongsToMany(AccountTransaction::class, "soundblock_accounts_transactions_invoices", "invoice_id", "transaction_id", "invoice_id", "row_id"));
    }
}
