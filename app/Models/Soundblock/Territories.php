<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Territories extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_data_territories";

    protected $primaryKey = "territory_id";
}
