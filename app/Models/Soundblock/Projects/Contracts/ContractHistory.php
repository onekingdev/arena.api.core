<?php

namespace App\Models\Soundblock\Projects\Contracts;

use App\Models\BaseModel;

class ContractHistory extends BaseModel
{
    protected $table = "soundblock_projects_contracts_history";

    protected $casts = [
        "contract_state" => "array",
    ];
}
