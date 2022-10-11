<?php

namespace App\Models\Soundblock\Accounts;

use App\Models\BaseModel;
use App\Models\Soundblock\Data\PlansType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountPlan extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_accounts_plans";

    protected $primaryKey = "plan_id";

    protected string $uuid = "plan_uuid";

    protected $guarded = [];

    protected $hidden = [
        "plan_id", "plan_type_id", "account_id", "ledger_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY
    ];

    public function account()
    {
        return($this->belongsTo(Account::class, "account_id", "account_id"));
    }

    public function scopeActive(Builder $query) : Builder {
        return $query->where("flag_active", true);
    }

    public function planType(){
        return ($this->hasOne(PlansType::class, "data_id", "plan_type_id"));
    }
}
