<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;

class Ledger extends BaseModel
{
    protected $table = "soundblock_ledger";

    protected $guarded = [];

    protected $primaryKey = "ledger_id";

    protected string $uuid = "ledger_uuid";

    protected $hidden = ["ledger_id"];

    protected $casts = [
        "qldb_block" => "array",
        "qldb_data" => "array",
        "qldb_metadata" => "array"
    ];

    public function history() {
        return $this->hasMany(LedgerHistory::class, "parent_id", "ledger_id");
    }

    public function metadata(){
        return ($this->hasOne(LedgerData::class, "ledger_id", "ledger_id"));
    }
}
