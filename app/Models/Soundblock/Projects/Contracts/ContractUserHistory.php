<?php

namespace App\Models\Soundblock\Projects\Contracts;

use App\Models\BaseModel;
use App\Models\Users\User;

class ContractUserHistory extends BaseModel
{
    protected $table = "soundblock_projects_contracts_users_history";

    protected $guarded = [];

    protected $casts = [
        "contract_users_state" => "array",
    ];

    public function user() {
        return $this->belongsTo(User::class, "user_id", "user_id");
    }

    public function contract() {
        return $this->belongsTo(Contract::class, "contract_id", "contract_id");
    }
}
