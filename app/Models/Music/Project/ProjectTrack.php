<?php

namespace App\Models\Music\Project;

use App\Helpers\Filesystem\Music;
use App\Models\BaseModel;
use App\Models\Music\Artist\Artist;
use App\Models\Music\Genre;
use App\Models\Music\Mood;
use App\Models\Music\Style;
use App\Models\Music\Theme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTrack extends BaseModel {
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = "stamp_created_at";
    const UPDATED_AT = "stamp_updated_at";
    const DELETED_AT = "stamp_deleted_at";

    protected $connection = "mysql-music";
    protected $table = "projects_tracks";
    protected $hidden = ["row_id", "project_id"];
    protected $primaryKey = "track_id";
    protected string $uuid = "track_uuid";
    protected $guarded = [];

    protected bool $ignoreBootEvents = true;

    public function project() {
        return ($this->belongsTo(Project::class, "project_id", "project_id"));
    }

    public function composers() {
        return ($this->belongsToMany(Artist::class, "projects_tracks_composers", "track_id", "artist_id", "track_id", "artist_id"));
    }

    public function features() {
        return ($this->belongsToMany(Artist::class, "projects_tracks_features", "track_id", "artist_id", "track_id", "artist_id"));
    }

    public function performers() {
        return ($this->belongsToMany(Artist::class, "projects_tracks_performers", "track_id", "artist_id", "track_id", "artist_id"));
    }

    public function genres() {
        return ($this->belongsToMany(Genre::class, "projects_tracks_genres", "track_id", "genre_id", "track_id", "genre_id"));
    }

    public function moods() {
        return ($this->belongsToMany(Mood::class, "projects_tracks_moods", "track_id", "mood_id", "track_id", "mood_id"));
    }

    public function styles() {
        return ($this->belongsToMany(Style::class, "projects_tracks_styles", "track_id", "style_id", "track_id", "style_id"));
    }

    public function themes() {
        return ($this->belongsToMany(Theme::class, "projects_tracks_themes", "track_id", "theme_id", "track_id", "theme_id"));
    }

    public function getUploadedAttribute(){
        if (bucket_storage("music")->exists(Music::project_track_path($this->project, $this->track_uuid))) {
            return (true);
        }

        return (false);
    }
}
