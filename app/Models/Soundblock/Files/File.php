<?php

namespace App\Models\Soundblock\Files;

use App\Models\BaseModel;
use App\Models\Soundblock\Artist;
use App\Models\Soundblock\Collections\Collection;
use App\Models\Soundblock\Data\Contributor;
use App\Models\Soundblock\Track;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Soundblock\Ledger;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends BaseModel {
    //
    use SoftDeletes, HasFactory;

    protected $table = "soundblock_files";

    protected $primaryKey = "file_id";

    protected string $uuid = "file_uuid";

    protected $guarded = [];

    protected $hidden = [
        "directory_id", "pivot", "file_id", "music", "video", "merch", "other", "ledger_id",
        "file_isrc", "file_duration", "track_number", "music_id", "music_uuid",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    protected $observables = [
        "modified",
    ];

    protected $appends = [
        "meta",
    ];

    public function track() {
        return ($this->hasOne(Track::class, "file_id", "file_id"));
    }

    public function other() {
        return ($this->hasOne(FileOther::class, "file_id", "file_id"));
    }

    public function video() {
        return ($this->hasOne(FileVideo::class, "file_id", "file_id"));
    }

    public function videoTrack() {
        return ($this->hasOne(FileVideo::class, "music_id", "file_id"));
    }

    public function merch() {
        return ($this->hasOne(FileMerch::class, "file_id", "file_id"));
    }

    public function directory() {
        return ($this->belongsTo(Directory::class, "directory_id", "directory_id"));
    }

    public function collectionshistory() {
        return ($this->belongsToMany(Collection::class, "soundblock_files_history", "file_id", "collection_id", "file_id", "collection_id")
                     ->whereNull("soundblock_files_history." . static::STAMP_DELETED)
                     ->withPivot("collection_uuid", "file_uuid", "file_action", "file_category", "file_memo")
                     ->orderBy(static::STAMP_CREATED, "asc")
                     ->withTimestamps(static::CREATED_AT, static::UPDATED_AT));
    }

    public function modified() {
        $this->fireModelEvent("modified", false);
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }

    public function getMetaAttribute() {
        $meta = [];

        switch ($this->file_category) {
            case "music" :
            {
                $objForCategory = $this->track;
                $strProject = $this->collections()->value("project_uuid");

                $meta = [
                    "type"          => "music",
                    "track_number"  => $objForCategory->track_number,
                    "track_duration" => $objForCategory->track_duration,
                    "track_isrc"     => $objForCategory->track_isrc,
                    "preview_start" => $objForCategory->preview_start,
                    "preview_stop"  => $objForCategory->preview_stop,
                    "cover"         => route("soundblock.project.track.cover", [
                        "project" => $strProject,
                        "file"    => $this->file_uuid,
                    ]),
                ];
                break;
            }
            case "video":
            {
                $objForCategory = $this->video;
                $meta = [
                    "type"       => "video",
                    "track_uuid" => $objForCategory->track ? $objForCategory->track->file_uuid : null,
                    "track"      => $objForCategory->track ? $objForCategory->track->only(["file_name", "file_title", "file_sortby"]) : null,
                    "file_isrc"  => $objForCategory->file_isrc,
                ];
                break;
            }
            case "merch":
            {
                $objForCategory = $this->merch;
                $meta = [
                    "type"     => "merch",
                    "file_sku" => $objForCategory->file_sku,
                ];
                break;
            }
            case "files":
            {
                $meta = [
                    "type" => "files",
                ];
                break;
            }
        }

        return ($meta);
    }

    public function collections() {
        return ($this->belongsToMany(Collection::class, "soundblock_collections_files", "file_id", "collection_id", "file_id", "collection_id")
                     ->withPivot("file_uuid", "collection_uuid")
                     ->whereNull("soundblock_collections_files." . static::STAMP_DELETED)
                     ->withTimestamps(static::CREATED_AT, static::UPDATED_AT));
    }

    public function getMetaLedgerAttribute() {
        $objForCategory = $this->{$this->file_category};
        $meta = [];

        if (!$objForCategory) {
            return ($meta);
        }

        switch ($this->file_category) {
            case "music" :
                $meta = [
                    "Type"     => "Music",
                    "Track"    => $objForCategory->track_number ?? "",
                    "Duration" => $objForCategory->track_duration ?? "",
                    "ISRC"     => $objForCategory->track_isrc ?? "",
                ];
                break;
            case "video":
            {
                $meta = [
                    "type"     => "Video",
                    "Track ID" => $objForCategory->track ? $objForCategory->track->file_uuid : "",
                    "ISRC"     => $objForCategory->file_isrc ?? "",
                ];
                break;
            }
            case "merch":
            {
                $meta = [
                    "Type"     => "Merch",
                    "SKU" => $objForCategory->file_sku ?? "",
                ];
                break;
            }
            case "files":
            {
                $meta = [
                    "Type" => "Files",
                ];
                break;
            }
        }

        return ($meta);
    }

    public function artists(){
        return ($this->belongsToMany(Artist::class, "soundblock_tracks_artists", "file_id", "artist_id", "file_id", "artist_id")
            ->whereNull("soundblock_tracks_artists." . BaseModel::STAMP_DELETED)
            ->select("soundblock_artists.artist_uuid", "soundblock_artists.artist_name", "soundblock_tracks_artists.artist_type")
        );
    }

    public function contributors(){
        return ($this->belongsToMany(Contributor::class, "soundblock_tracks_contributors", "file_id", "contributor_id", "file_id", "data_id")
            ->whereNull("soundblock_tracks_contributors." . BaseModel::STAMP_DELETED)
        );
    }
}
