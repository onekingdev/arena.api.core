<?php

namespace App\Models\Music\Artist;

use App\Models\BaseModel;
use App\Models\Music\Genre;
use App\Models\Music\Mood;
use App\Models\Music\Project\Project;
use App\Models\Music\Style;
use App\Models\Music\Theme;
use App\Traits\BaseScalable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist extends BaseModel
{
    use HasFactory;
    use BaseScalable;

    protected $connection = "mysql-music";

    protected $hidden = [
        "artist_id", "arena_id", "pivot"
    ];

    protected $primaryKey = "artist_id";

    const CREATED_AT = "stamp_created_at";
    const UPDATED_AT = "stamp_updated_at";

    protected string $uuid = "artist_uuid";

    protected $guarded = [];

    public bool $ignoreBootEvents = true;

    public $metaData = [
        "filters" => [
            "flag_allmusic" => [
                "column" => "flag_allmusic"
            ],
            "flag_amazon" => [
                "column" => "flag_amazon"
            ],
            "flag_itunes" => [
                "column" => "flag_itunes"
            ],
            "flag_lastfm" => [
                "column" => "flag_lastfm"
            ],
            "flag_spotify" => [
                "column" => "flag_spotify"
            ],
            "flag_wikipedia" => [
                "column" => "flag_wikipedia"
            ]
        ],
        "search" => [
            "artist_name" => [
                "column" => "artist_name"
            ],
            "artist_active" => [
                "column" => "artist_active"
            ],
            "artist_born" => [
                "column" => "artist_born"
            ],
        ],
        "sort" => [
            "flag_allmusic" => [
                "column" => "flag_allmusic"
            ],
            "flag_amazon" => [
                "column" => "flag_amazon"
            ],
            "flag_itunes" => [
                "column" => "flag_itunes"
            ],
            "flag_lastfm" => [
                "column" => "flag_lastfm"
            ],
            "flag_spotify" => [
                "column" => "flag_spotify"
            ],
            "flag_wikipedia" => [
                "column" => "flag_wikipedia"
            ],
            "artist_name" => [
                "column" => "artist_name"
            ],
            "artist_active" => [
                "column" => "artist_active"
            ],
            "artist_born" => [
                "column" => "artist_born"
            ],
        ]
    ];

    public function projects() {
        return $this->hasMany(Project::class, "artist_id", "artist_id");
    }

    public function alias() {
        return $this->hasMany(ArtistAlias::class, "artist_id", "artist_id");
    }

    public function genres() {
        return ($this->belongsToMany(Genre::class, "artists_genres", "artist_id", "genre_id", "artist_id", "genre_id"));
    }

    public function members() {
        return $this->belongsToMany(Artist::class, "artists_members", "artist_id", "artist_id", "artist_id", "artist_id");
    }

    public function styles() {
        return ($this->belongsToMany(Style::class, "artists_styles", "artist_id", "style_id", "artist_id", "style_id"));
    }

    public function themes() {
        return ($this->belongsToMany(Theme::class, "artists_themes", "artist_id", "theme_id", "artist_id", "theme_id"));
    }

    public function influenced() {
        return $this->hasMany(ArtistInfluenced::class, "artist_id", "artist_id");
    }

    public function moods() {
        return ($this->belongsToMany(Mood::class, "artists_moods", "artist_id", "mood_id", "artist_id", "mood_id"));
    }
}
