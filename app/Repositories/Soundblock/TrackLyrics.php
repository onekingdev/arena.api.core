<?php

namespace App\Repositories\Soundblock;

use App\Models\Soundblock\TrackLyrics as TrackLyricsModel;
use App\Repositories\BaseRepository;

class TrackLyrics extends BaseRepository {
    /**
     * UpcCodes constructor.
     * @param TrackLyricsModel $model
     */
    public function __construct(TrackLyricsModel $model) {
        $this->model = $model;
    }

    public function findAllByTrack(string $track){
        return ($this->model->where("track_uuid", $track)->with("language")->get());
    }

    public function updateTrackLyrics(TrackLyricsModel $objLyrics, string $lyrics){
        return (
            $objLyrics->update([
                "track_lyrics" => $lyrics
            ])
        );
    }
}
