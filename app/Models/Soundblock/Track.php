<?php

namespace App\Models\Soundblock;

use App\Models\BaseModel;
use App\Models\Casts\StampCast;
use App\Models\Soundblock\Data\Contributor;
use App\Models\Soundblock\Data\Genre;
use App\Models\Soundblock\Data\Language;
use App\Models\Soundblock\Files\File;
use App\Traits\StampAttribute;
use App\Models\Soundblock\Collections\Collection;

class Track extends BaseModel {
    use StampAttribute;

    protected $table = "soundblock_tracks";

    protected $primaryKey = "track_id";

    protected string $uuid = "track_uuid";

    protected $guarded = [];

    protected $hidden = [
        "track_id", "file_id", "genre_primary_id", "genre_secondary_id", "track_language_id", "track_language_vocals_id",
        "ledger_id", BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY, BaseModel::UPDATED_AT,
        BaseModel::STAMP_UPDATED_BY, BaseModel::CREATED_AT, BaseModel::STAMP_CREATED_BY,
    ];

    protected $casts = [
        BaseModel::STAMP_CREATED_BY => StampCast::class,
        BaseModel::STAMP_UPDATED_BY => StampCast::class,
    ];

    public function file() {
        return ($this->belongsTo(File::class, "file_id", "file_id"));
    }

    public function collections() {
        return ($this->belongsToMany(Collection::class, "soundblock_collections_files", "file_id", "collection_id", "file_id", "collection_id")
                     ->whereNull("soundblock_collections_files." . BaseModel::STAMP_DELETED)
                     ->withTimestamps(BaseModel::CREATED_AT, BaseModel::UPDATED_AT));
    }

    public function artists(){
        return ($this->belongsToMany(Artist::class, "soundblock_tracks_artists", "track_id", "artist_id", "track_id", "artist_id")
            ->whereNull("soundblock_tracks_artists." . BaseModel::STAMP_DELETED)
            ->select(
                "soundblock_artists.artist_uuid",
                "soundblock_artists.artist_name",
                "soundblock_artists.account_uuid",
                "soundblock_tracks_artists.artist_type"
            )
        );
    }

    public function contributors(){
        return ($this->belongsToMany(Contributor::class, "soundblock_tracks_contributors", "track_id", "contributor_id", "track_id", "data_id")
            ->whereNull("soundblock_tracks_contributors." . BaseModel::STAMP_DELETED)
            ->select("soundblock_tracks_contributors.contributor_name", "soundblock_data_contributors.data_contributor", "soundblock_data_contributors.data_uuid")
        );
    }

    public function publisher(){
        return ($this->belongsToMany(ArtistPublisher::class, "soundblock_tracks_publishers", "track_id", "publisher_id", "track_id", "publisher_id")
            ->whereNull("soundblock_tracks_publishers." . BaseModel::STAMP_DELETED)
        );
    }

    public function primaryGenre(){
        return ($this->hasOne(Genre::class, "data_id", "genre_primary_id"));
    }

    public function secondaryGenre(){
        return ($this->hasOne(Genre::class, "data_id", "genre_secondary_id"));
    }

    public function notes(){
        return ($this->hasMany(TrackNote::Class, "track_id", "track_id"));
    }

    public function language(){
        return ($this->hasOne(Language::class, "data_id", "track_language_id"));
    }

    public function languageVocals(){
        return ($this->hasOne(Language::class, "data_id", "track_language_vocals_id"));
    }

    public function lyrics(){
        return ($this->hasMany(TrackLyrics::class, "track_id", "track_id"));
    }

    public function history(){
        return ($this->hasMany(TrackHistory::class, "track_id", "track_id"));
    }

    public function ledger() {
        return $this->belongsTo(Ledger::class, "ledger_id", "ledger_id");
    }
}
