<?php

namespace App\Repositories\Soundblock;

use App\Models\Soundblock\TrackNote;
use App\Repositories\BaseRepository;

class TrackNotes extends BaseRepository {
    /**
     * UpcCodes constructor.
     * @param TrackNote $model
     */
    public function __construct(TrackNote $model) {
        $this->model = $model;
    }

    public function findAllByTrack(string $track){
        return ($this->model->where("track_uuid", $track)->with("language")->get());
    }

    public function updateTrackNote(TrackNote $objNote, string $note){
        return (
            $objNote->update([
                "track_note" => $note
            ])
        );
    }
}
