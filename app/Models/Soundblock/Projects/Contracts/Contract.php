<?php

namespace App\Models\Soundblock\Projects\Contracts;

use App\Models\BaseModel;
use App\Models\Soundblock\Projects\Project;
use App\Models\Users\User;
use App\Models\Soundblock\Ledger;
use App\Models\Soundblock\Invites;
use App\Models\Soundblock\Accounts\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends BaseModel {
    use HasFactory;

    const STAMP_BEGINS = "stamp_begins";
    const IDX_STAMP_BEGINS = "idx_stamp-begins";
    const STAMP_ENDS = "stamp_ends";
    const IDX_STAMP_ENDS = "idx_stamp-ends";
    protected $table = "soundblock_projects_contracts";
    protected $primaryKey = "contract_id";
    protected string $uuid = "contract_uuid";
    protected $guarded = [];
    protected $hidden = [
        "contract_id", "project_id", "account_id", "ledger_id", "ledger_id",  BaseModel::DELETED_AT,
        BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT, "pivot" //
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->stamp_begins = time();
        });
    }

    public function project() {
        return ($this->belongsTo(Project::class, "project_id", "project_id"));
    }

    public function users() {
        return ($this->belongsToMany(User::class, "soundblock_projects_contracts_users", "contract_id", "user_id", "contract_id", "user_id")
                     ->whereNull("soundblock_projects_contracts_users." . BaseModel::STAMP_DELETED)
                     ->withPivot("contract_uuid", "user_uuid", "invite_id", "invite_uuid", "user_payout", "contract_status", "flag_action", "stamp_remind")
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function invites() {
        return ($this->morphMany(Invites::class, "invitable", "model_class", "model_id"));
    }

    public function contractInvites() {
        return ($this->belongsToMany(Invites::class, "soundblock_projects_contracts_users", "contract_id", "invite_id", "contract_id", "invite_id")
                     ->whereNull("soundblock_projects_contracts_users." . BaseModel::STAMP_DELETED)
                     ->withPivot("invite_uuid", "contract_uuid", "user_id", "user_uuid", "user_payout", "contract_status", "stamp_remind")
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function history() {
        return $this->hasMany(ContractHistory::class, "contract_id", "contract_id");
    }

    public function usersHistory() {
        return $this->hasMany(ContractUserHistory::class, "contract_id", "contract_id");
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }

    public function account() {
        return $this->belongsTo(Account::class, "account_id", "account_id");
    }
}
