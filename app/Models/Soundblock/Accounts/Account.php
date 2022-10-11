<?php

namespace App\Models\Soundblock\Accounts;

use App\Models\BaseModel;
use App\Models\Soundblock\Ledger;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Artist as ArtistModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Soundblock\Projects\ProjectDraft;
use App\Models\Accounting\AccountingFailedPayments;

/**
 * @property \Illuminate\Database\Eloquent\Collection transactions
 * @property User user
 */
class Account extends BaseModel {
    //
    use SoftDeletes, HasFactory;

    protected $table = "soundblock_accounts";

    protected $primaryKey = "account_id";

    protected string $uuid = "account_uuid";

    protected $hidden = [
        "plan_id", "account_id", "user_id", "user", "ledger_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::STAMP_CREATED, BaseModel::STAMP_UPDATED,
    ];

    protected $guarded = [];

    protected $appends = ["account_holder"];

    public function user() {
        return ($this->belongsTo(User::class, "user_id", "user_id"));
    }

    public function users() {
        return ($this->belongsToMany(User::class, "soundblock_accounts_users", "account_id", "user_id", "account_id", "user_id"))
            ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT)
            ->withPivot(BaseModel::STAMP_DELETED, "flag_accepted");
    }

    public function projects() {
        return ($this->hasMany(Project::class, "account_id", "account_id"));
    }

    public function transactions() {
        return ($this->hasMany(AccountTransaction::class, "account_id", "account_id"));
    }

    public function plans() {
        return ($this->hasMany(AccountPlan::class, "account_id", "account_id"));
    }

    public function activePlan() {
        return ($this->hasOne(AccountPlan::class, "account_id", "account_id")
            ->where("flag_active", true));
    }

    public function drafts() {
        return ($this->hasMany(ProjectDraft::class, "account_id", "account_id"));
    }

    public function failedPayments() {
        return $this->hasMany(AccountingFailedPayments::class, "account_id", "account_id");
    }

    public function downloads() {
        if ($this->transactions->count() == 0) {
            return (0);
        } else {
            return ($this->transactions()->where("transaction_name", "download")->count());
        }

    }

    public function notes() {
        return ($this->hasMany(AccountNote::class, "account_id", "account_id"));
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }

    public function scopeActive(Builder $builder) {
        return $builder->where("flag_status", "active");
    }

    public function getAccountHolderAttribute() {
        return($this->user->name);
    }

    public function artists(){
        return ($this->hasMany(ArtistModel::class, "account_id", "account_id"));
    }
}
