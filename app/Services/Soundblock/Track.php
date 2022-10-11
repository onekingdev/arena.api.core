<?php

namespace App\Services\Soundblock;

use App\Jobs\Soundblock\Ledger\TrackLedger;
use App\Services\Soundblock\Ledger\TrackLedger as TrackLedgerService;
use Illuminate\Support\Facades\Bus;
use Util;
use App\Models\{
    BaseModel,
    Soundblock\Track as TrackModel,
    Soundblock\Artist as ArtistModel,
    Soundblock\TrackNote as TrackNoteModel,
    Soundblock\TrackLyrics as TrackLyricsModel,
    Soundblock\Data\Language as LanguageModel,
    Soundblock\Data\Contributor as ContributorModel,
    Soundblock\ArtistPublisher as ArtistPublisherModel
};
use App\Repositories\{
    Soundblock\TrackNotes as TrackNotesRepository,
    Soundblock\TrackLyrics as TrackLyricsRepository,
    Soundblock\TrackHistory as TrackHistoryRepository
};

class Track {
    /** @var TrackNotesRepository */
    private TrackNotesRepository $trackNotesRepo;
    /** @var TrackLyricsRepository */
    private TrackLyricsRepository $trackLyricsRepo;
    /** @var TrackHistoryRepository */
    private TrackHistoryRepository $trackHistoryRepo;

    /**
     * TrackService constructor.
     * @param TrackNotesRepository $trackNotesRepo
     * @param TrackLyricsRepository $trackLyricsRepo
     * @param TrackHistoryRepository $trackHistoryRepo
     */
    public function __construct(TrackNotesRepository $trackNotesRepo, TrackLyricsRepository $trackLyricsRepo,
                                TrackHistoryRepository $trackHistoryRepo) {
        $this->trackNotesRepo = $trackNotesRepo;
        $this->trackLyricsRepo = $trackLyricsRepo;
        $this->trackHistoryRepo = $trackHistoryRepo;
    }

    public function storeNote(TrackModel $objTrack, LanguageModel $objLanguage, string $note){
        $arrTrackNote = [
            "note_uuid" => Util::uuid(),
            "track_id" => $objTrack->track_id,
            "track_uuid" => $objTrack->track_uuid,
            "language_id" => $objLanguage->data_id,
            "language_uuid" => $objLanguage->data_uuid,
            "track_note" => $note
        ];

        $arrOldNotes = $objTrack->notes->toArray();
        $objNote = $this->trackNotesRepo->create($arrTrackNote);
        $objTrack->refresh();
        $arrNewNotes = $objTrack->notes->toArray();
        $this->storeTrackHistory($objTrack, json_encode($arrOldNotes), json_encode($arrNewNotes), "notes");

        return ($objNote);
    }

    public function storeLyrics(TrackModel $objTrack, LanguageModel $objLanguage, string $lyrics){
        $arrTrackLyrics = [
            "lyrics_uuid" => Util::uuid(),
            "track_id" => $objTrack->track_id,
            "track_uuid" => $objTrack->track_uuid,
            "language_id" => $objLanguage->data_id,
            "language_uuid" => $objLanguage->data_uuid,
            "track_lyrics" => $lyrics
        ];

        $arrOldLyrics = $objTrack->lyrics;
        $objLyrics = $this->trackLyricsRepo->create($arrTrackLyrics);
        $objTrack->refresh();
        $arrNewLyrics = $objTrack->lyrics;
        $this->storeTrackHistory($objTrack, json_encode($arrOldLyrics), json_encode($arrNewLyrics), "lyrics");

        return ($objLyrics);
    }

    public function updateNote(TrackNoteModel $objNote, string $note){
        return ($this->trackNotesRepo->updateTrackNote($objNote, $note));
    }
    
    public function updateLyrics(TrackLyricsModel $objLyrics, string $lyrics){
        return ($this->trackLyricsRepo->updateTrackLyrics($objLyrics, $lyrics));
    }

    public function deleteLyrics(TrackLyricsModel $objLyrics){
        $objTrack = $objLyrics->track;
        $arrOldLyrics = $objTrack->lyrics;
        $boolResult = $this->trackLyricsRepo->destroy($objLyrics->lyrics_id);
        $objTrack->refresh();
        $arrNewLyrics = $objTrack->lyrics;
        $this->storeTrackHistory($objTrack, json_encode($arrOldLyrics), json_encode($arrNewLyrics), "lyrics");

        return ($boolResult);
    }

    public function deleteNote(TrackNoteModel $objNote){
        $objTrack = $objNote->track;
        $arrOldNotes = $objTrack->notes;
        $boolResult = $this->trackNotesRepo->destroy($objNote->note_id);
        $objTrack->refresh();
        $arrNewNotes = $objTrack->notes;
        $this->storeTrackHistory($objTrack, json_encode($arrOldNotes), json_encode($arrNewNotes), "notes");

        return ($boolResult);
    }

    public function storeArtist(TrackModel $objTrack, ArtistModel $objArtist, int $user_id, string $type){
        $arrOldArtists = $objTrack->artists;
        $objTrack->artists()->attach($objArtist->artist_id, [
            "row_uuid" => Util::uuid(),
            "file_id" => $objTrack->file_id,
            "file_uuid" => $objTrack->file_uuid,
            "track_uuid" => $objTrack->track_uuid,
            "artist_uuid" => $objArtist->artist_uuid,
            "artist_type" => $type,
            BaseModel::STAMP_CREATED    => Util::current_time(),
            BaseModel::STAMP_CREATED_BY => $user_id,
            BaseModel::STAMP_UPDATED    => Util::current_time(),
            BaseModel::STAMP_UPDATED_BY => $user_id,
        ]);
        $objTrack->refresh();
        $arrNewArtists = $objTrack->artists;
        $this->storeTrackHistory($objTrack, json_encode($arrOldArtists), json_encode($arrNewArtists), "artists");

        return ($objTrack);
    }

    public function deleteArtist(TrackModel $objTrack, ArtistModel $objArtist){
        $arrOldArtists = $objTrack->artists;
        $objTrack->artists()->detach($objArtist->artist_id);
        $objTrack->refresh();
        $arrNewArtists = $objTrack->artists;
        $this->storeTrackHistory($objTrack, json_encode($arrOldArtists), json_encode($arrNewArtists), "artists");

        return ($objTrack);
    }

    public function storePublisher(TrackModel $objTrack, ArtistPublisherModel $objArtistPublisher, int $user_id){
        $arrOldPublishers = $objTrack->publisher;
        $objTrack->publisher()->attach($objArtistPublisher->publisher_id, [
            "row_uuid" => Util::uuid(),
            "file_id" => $objTrack->file_id,
            "file_uuid" => $objTrack->file_uuid,
            "track_uuid" => $objTrack->track_uuid,
            "publisher_uuid" => $objArtistPublisher->publisher_uuid,
            BaseModel::STAMP_CREATED    => Util::current_time(),
            BaseModel::STAMP_CREATED_BY => $user_id,
            BaseModel::STAMP_UPDATED    => Util::current_time(),
            BaseModel::STAMP_UPDATED_BY => $user_id,
        ]);
        $objTrack->refresh();
        $arrNewPublishers = $objTrack->publisher;
        $this->storeTrackHistory($objTrack, json_encode($arrOldPublishers), json_encode($arrNewPublishers), "publishers");

        return ($objTrack);
    }

    public function deletePublisher(TrackModel $objTrack, ArtistPublisherModel $objArtistPublisher){
        $arrOldPublishers = $objTrack->publisher;
        $objTrack->publisher()->detach($objArtistPublisher->publisher_id);
        $objTrack->refresh();
        $arrNewPublishers = $objTrack->publisher;
        $this->storeTrackHistory($objTrack, json_encode($arrOldPublishers), json_encode($arrNewPublishers), "publishers");

        return ($objTrack);
    }

    public function storeContributor(TrackModel $objTrack, ContributorModel $objContributor, int $user_id, string $name){
        $arrOldContributors = $objTrack->contributors;
        $objTrack->contributors()->attach($objContributor->data_id, [
            "row_uuid" => Util::uuid(),
            "file_id" => $objTrack->file_id,
            "file_uuid" => $objTrack->file_uuid,
            "track_uuid" => $objTrack->track_uuid,
            "contributor_uuid" => $objContributor->data_uuid,
            "contributor_name" => $name,
            BaseModel::STAMP_CREATED    => Util::current_time(),
            BaseModel::STAMP_CREATED_BY => $user_id,
            BaseModel::STAMP_UPDATED    => Util::current_time(),
            BaseModel::STAMP_UPDATED_BY => $user_id,
        ]);
        $objTrack->refresh();
        $arrNewContributors = $objTrack->contributors;
        $this->storeTrackHistory($objTrack, json_encode($arrOldContributors), json_encode($arrNewContributors), "contributors");

        return ($objTrack);
    }

    public function deleteContributor(TrackModel $objTrack, ContributorModel $objContributor){
        $arrOldContributors = $objTrack->contributors;
        $objTrack->contributors()->detach($objContributor->data_id);
        $objTrack->refresh();
        $arrNewContributors = $objTrack->contributors;
        $this->storeTrackHistory($objTrack, json_encode($arrOldContributors), json_encode($arrNewContributors), "contributors");

        return ($objTrack);
    }

    private function storeTrackHistory(TrackModel $objTrack, string $oldVal, string $newVal, string $field_name){
        $changes = [];
        $this->trackHistoryRepo->create([
            "track_id" => $objTrack->track_id,
            "track_uuid" => $objTrack->track_uuid,
            "field_name" => $field_name,
            "old_value" => $oldVal,
            "new_value" => $newVal,
        ]);
        $changes[ucfirst($field_name)] = [
            "Previous value" => $oldVal,
            "Changed to" => $newVal
        ];

        Bus::chain([new TrackLedger($objTrack, TrackLedgerService::UPDATE_EVENT, $changes)])->onQueue("ledger")->dispatch();
    }
}
