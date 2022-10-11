<?php

namespace App\Models\Soundblock\Accounts;

use App\Repositories\Soundblock\Data\PlansTypes;
use App\Models\{
    BaseModel,
    Soundblock\Ledger,
};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountTransaction extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_accounts_transactions";

    protected $primaryKey = "transaction_id";

    protected string $uuid = "transaction_uuid";

    protected $guarded = [];

    protected $hidden = [
        "transaction_id", "account_id", "ledger_id", "plan_type_id",
        BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    public function account() {
        return ($this->belongsTo(Account::class, "account_id", "account_id"));
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }

    public function planType()
    {
        return $this->belongsTo(PlansTypes::class, "data_id", "plan_type_id");
    }

    public function invoice(){
        return ($this->hasOneThrough(AccountInvoice::class, "soundblock_accounts_transactions_invoices", "transaction_id", "invoice_id", "transaction_id", "invoice_id"));
    }
}
