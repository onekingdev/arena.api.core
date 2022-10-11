<?php

namespace App\Models\Music\Project;

use App\Traits\BaseScalable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Music\{Artist\Artist, Core\TranscoderJob, Genre, Mood, Style, Theme};

class Project extends Model {
    use HasFactory;
    use BaseScalable;
    use SoftDeletes;

    const CREATED_AT = "stamp_created_at";
    const UPDATED_AT = "stamp_updated_at";
    const DELETED_AT = "stamp_deleted_at";

    protected $connection = "mysql-music";
    protected $hidden = [
        "project_id", "artist_id",
    ];
    protected $primaryKey = "project_id";
    protected string $uuid = "project_uuid";

    protected $guarded = [];

    protected $casts = [
        "flag_office_complete" => "boolean",
        "flag_dead" => "boolean",
    ];

    public $metaData = [
        "filters" => [
            "artist" => [
                "column" => "artist_uuid"
            ],
            "project_type" => [
                "column" => "project_type"
            ],
            "project_year" => [
                "column" => "project_year"
            ],
            "source" => [
                "column" => "stamp_source"
            ],
            "flag_allmusic" => [
                "column" => "flag_allmusic"
            ],
            "flag_office_hide" => [
                "column" => "flag_office_hide"
            ],
            "flag_office_complete" => [
                "column" => "flag_office_complete"
            ],
            "flag_dead" => [
                "column" => "flag_dead"
            ],
        ],
        "search" => [
            "project_date" => [
                "column" => "project_date"
            ],
            "project_name" => [
                "column" => "project_name"
            ],
            "project_label" => [
                "column" => "project_label"
            ]
        ],
        "sort" => [
            "project_type" => [
                "column" => "project_type"
            ],
            "project_year" => [
                "column" => "project_year"
            ],
            "project_date" => [
                "column" => "project_date"
            ],
            "source" => [
                "column" => "stamp_source"
            ],
            "flag_allmusic" => [
                "column" => "flag_allmusic"
            ],
            "flag_office_hide" => [
                "column" => "flag_office_hide"
            ],
            "flag_office_complete" => [
                "column" => "flag_office_complete"
            ],
            "flag_dead" => [
                "column" => "flag_dead"
            ],
        ]
    ];

    public function artist() {
        return $this->belongsTo(Artist::class, "artist_id", "artist_id");
    }

    public function genres() {
        return ($this->belongsToMany(Genre::class, "projects_genres", "project_id", "genre_id", "project_id", "genre_id"));
    }

    public function moods() {
        return ($this->belongsToMany(Mood::class, "projects_moods", "project_id", "mood_id", "project_id", "mood_id"));
    }

    public function styles() {
        return ($this->belongsToMany(Style::class, "projects_styles", "project_id", "style_id", "project_id", "style_id"));
    }

    public function themes() {
        return ($this->belongsToMany(Theme::class, "projects_themes", "project_id", "theme_id", "project_id", "theme_id"));
    }

    public function tracks() {
        return $this->hasMany(ProjectTrack::class, "project_id", "project_id");
    }

    public function transcoderJobs() {
        return $this->hasMany(TranscoderJob::class, "project_id", "project_id");
    }
}
