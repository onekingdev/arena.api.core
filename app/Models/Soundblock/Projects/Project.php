<?php

namespace App\Models\Soundblock\Projects;

use App\Helpers\Filesystem\Soundblock;
use App\Models\BaseModel;
use App\Models\Soundblock\Artist;
use App\Models\Soundblock\Audit\Bandwidth;
use App\Models\Soundblock\Data\Genre;
use App\Models\Soundblock\Data\Language;
use App\Models\Soundblock\Data\ProjectsFormat;
use App\Models\Soundblock\Ledger;
use App\Models\Soundblock\Reports\BandwidthMonthlyReport;
use App\Models\Soundblock\Reports\BandwidthReport;
use App\Models\Soundblock\Audit\Diskspace;
use App\Models\Soundblock\Reports\DiskspaceMonthlyReport;
use App\Models\Soundblock\Reports\DiskspaceReport;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Projects\Contracts\Contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Soundblock\Projects\Deployments\Deployment;

class Project extends BaseModel {
    use HasFactory;

    const SORTABLE_FIELDS = [
        "project_title", "project_type", "stamp_created_at", "stamp_updated_at",
    ];

    protected $table = "soundblock_projects";

    protected $primaryKey = "project_id";

    protected string $uuid = "project_uuid";

    protected $guarded = [];

    protected $hidden = [
        "project_id", "account_id", "ledger_id", "artist_id", "format_id", "genre_primary_id", "genre_secondary_id", "project_language_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT, BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    protected $appends = ["artwork"];

    public $metaData = [
        "filters" => [
            "account" => [
                "column" => "account_uuid"
            ],
            "artist" => [
                "column" => "artist_uuid"
            ],
            "format" => [
                "relation" => "format",
                "relation_table" => "soundblock_data_projects_formats",
                "column" => "data_format"
            ],
            "project_compilation" => [
                "column" => "flag_project_compilation"
            ],
            "flag_project_explicit" => [
                "column" => "flag_project_explicit"
            ],
            "language" => [
                "relation" => "language",
                "relation_table" => "soundblock_data_languages",
                "column" => "data_language"
            ],
            "primary_genre" => [
                "relation" => "primaryGenre",
                "relation_table" => "soundblock_data_genres",
                "column" => "data_genre"
            ],
            "secondary_genre" => [
                "relation" => "secondaryGenre",
                "relation_table" => "soundblock_data_genres",
                "column" => "data_genre"
            ],
            "deployment_status" => [
                "relation" => "deployments",
                "relation_table" => "soundblock_projects_deployments",
                "column" => "deployment_status"
            ]
        ],
        "search" => [
            "title" => [
                "column" => "project_title"
            ],
            "label" => [
                "column" => "project_label"
            ],
            "artist" => [
                "column" => "project_artist"
            ]
        ],
        "sort" => [
            "project_compilation" => [
                "column" => "flag_project_compilation"
            ],
            "flag_project_explicit" => [
                "column" => "flag_project_explicit"
            ],
            "title" => [
                "column" => "project_title"
            ],
            "created" => [
                "column" => "stamp_created"
            ]
        ],
    ];

    /**
     * The projects that belongs to the user
     */
    public function account() {
        return ($this->belongsTo(Account::class, "account_id", "account_id"));
    }

    public function contracts() {
        return ($this->hasMany(Contract::class, "project_id", "project_id"));
    }

    public function team() {
        return ($this->hasOne(Team::class, "project_id", "project_id"));
    }

    public function collections() {
        return ($this->hasMany(Collection::class, "project_id", "project_id"));
    }

    public function notes() {
        return ($this->hasMany(ProjectNote::class, "project_id", "project_id"));
    }

    public function getArtworkAttribute() {
        return (cloud_url("soundblock") . Soundblock::project_artwork_path($this));
    }

    public function getDeploymentAttribute() {
        return ($this->deployments()->orderBy("collection_id", "desc")->first());
    }

    public function deployments() {
        return ($this->hasMany(Deployment::class, "project_id", "project_id"));
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }

    public function bandwidth() {
        return $this->hasMany(Bandwidth::class, "project_id", "project_id");
    }

    public function diskSpaceAudit() {
        return $this->hasMany(Diskspace::class, "project_id", "project_id");
    }

    public function bandwidthReport() {
        return $this->hasMany(BandwidthReport::class, "project_id", "project_id");
    }

    public function bandwidthMontlyReport() {
        return $this->hasMany(BandwidthMonthlyReport::class, "project_id", "project_id");
    }

    public function diskSpaceReport() {
        return $this->hasMany(DiskspaceReport::class, "project_id", "project_id");
    }

    public function diskSpaceMontlyReport() {
        return $this->hasMany(DiskspaceMonthlyReport::class, "project_id", "project_id");
    }

    public function artist() {
        return $this->belongsTo(Artist::class, "artist_id", "artist_id");
    }

    public function artists(){
        return ($this->belongsToMany(Artist::class, "soundblock_projects_artists", "project_id", "artist_id", "project_id", "artist_id")
            ->whereNull("soundblock_projects_artists." . BaseModel::STAMP_DELETED)
            ->select(
                "soundblock_artists.artist_uuid",
                "soundblock_artists.artist_name",
                "soundblock_projects_artists.artist_type",
                "soundblock_artists.url_apple",
                "soundblock_artists.url_soundcloud",
                "soundblock_artists.url_spotify"
            )
        );
    }

    public function format() {
        return $this->hasOne(ProjectsFormat::class, "data_id", "format_id");
    }

    public function primaryGenre(){
        return ($this->hasOne(Genre::class, "data_id", "genre_primary_id"));
    }

    public function secondaryGenre(){
        return ($this->hasOne(Genre::class, "data_id", "genre_secondary_id"));
    }

    public function language(){
        return ($this->hasOne(Language::class, "data_id", "project_language_id"));
    }
}
