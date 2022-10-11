<?php

namespace App\Models\Soundblock\Data;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IsrcCode extends BaseModel
{
    use HasFactory;

    protected $table = "soundblock_data_codes_isrc";

    protected $primaryKey = "data_id";
}
