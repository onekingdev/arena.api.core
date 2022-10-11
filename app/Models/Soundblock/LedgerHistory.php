<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LedgerHistory extends BaseModel {
    use HasFactory;

    protected $table = "soundblock_ledger_history";

    protected $guarded = [];

    protected $primaryKey = "row_id";

    protected $casts = [
        "qldb_block"    => "array",
        "qldb_data"     => "array",
        "qldb_metadata" => "array",
    ];

    public function parent() {
        return $this->belongsTo(Ledger::class, "parent_id", "ledger_id");
    }
}
