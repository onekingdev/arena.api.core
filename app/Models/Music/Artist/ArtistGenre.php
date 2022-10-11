<?php

namespace App\Models\Music\Artist;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistGenre extends Model
{
    use HasFactory;

    protected $connection = "mysql-music";

    protected $table = "artists_genres";

    protected $hidden = ["row_id", "artist_id"];

    protected $primaryKey = "row_id";

    protected $guarded = [];

    const CREATED_AT = "stamp_created_at";
    const UPDATED_AT = "stamp_updated_at";

}
