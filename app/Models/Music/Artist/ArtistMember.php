<?php

namespace App\Models\Music\Artist;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtistMember extends BaseModel
{
    use HasFactory;

    protected $connection = "mysql-music";

    protected $table = "artists_members";

    protected $hidden = ["row_id", "artist_id"];

    protected $primaryKey = "row_id";

    protected $guarded = [];

    protected string $uuid = "row_uuid";

    public bool $ignoreBootEvents = true;

    const CREATED_AT = "stamp_created_at";
    const UPDATED_AT = "stamp_updated_at";
}
