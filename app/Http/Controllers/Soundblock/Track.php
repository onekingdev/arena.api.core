<?php

namespace App\Http\Controllers\Soundblock;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Soundblock\Track as TrackService;
use App\Services\Core\Auth\AuthGroup as AuthGroupService;
use App\Repositories\Soundblock\{
    File as FileRepository,
    Data\Languages as LanguagesRepository,
    TrackNotes as TrackNotesRepository,
    TrackLyrics as TrackLyricsRepository,
    Artist as ArtistRepository,
    ArtistPublisher as ArtistPublisherRepository,
    Data\Contributors as ContributorsRepository
};
use App\Http\Requests\Soundblock\Track\{ArtistDelete,
    ArtistsStore,
    ContributorStore,
    LyricsDelete,
    LyricsStore,
    LyricsUpdate,
    NoteDelete,
    NoteStore,
    NoteUpdate,
    PublisherStore};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Track extends Controller
{
    /** @var TrackService */
    private TrackService $trackService;
    /** @var LanguagesRepository */
    private LanguagesRepository $languagesRepo;
    /** @var FileRepository */
    private FileRepository $fileRepo;
    /** @var TrackNotesRepository */
    private TrackNotesRepository $trackNotesRepo;
    /** @var TrackLyricsRepository */
    private TrackLyricsRepository $trackLyricsRepo;
    /** @var AuthGroupService */
    private AuthGroupService $authGroupService;
    /** @var ArtistRepository */
    private ArtistRepository $artistRepo;
    /** @var ArtistPublisherRepository */
    private ArtistPublisherRepository $artistPublisherRepo;
    /** @var ContributorsRepository */
    private ContributorsRepository $contributorsRepo;

    /**
     * Track constructor.
     * @param TrackService $trackService
     * @param LanguagesRepository $languagesRepo
     * @param FileRepository $fileRepo
     * @param TrackNotesRepository $trackNotesRepo
     * @param TrackLyricsRepository $trackLyricsRepo
     * @param AuthGroupService $authGroupService
     * @param ArtistRepository $artistRepo
     * @param ArtistPublisherRepository $artistPublisherRepo
     * @param ContributorsRepository $contributorsRepo
     */
    public function __construct(TrackService $trackService, LanguagesRepository $languagesRepo, FileRepository $fileRepo,
                                TrackNotesRepository $trackNotesRepo, TrackLyricsRepository $trackLyricsRepo,
                                AuthGroupService $authGroupService, ArtistRepository $artistRepo,
                                ArtistPublisherRepository $artistPublisherRepo, ContributorsRepository $contributorsRepo){
        $this->trackService = $trackService;
        $this->languagesRepo = $languagesRepo;
        $this->fileRepo = $fileRepo;
        $this->trackNotesRepo = $trackNotesRepo;
        $this->trackLyricsRepo = $trackLyricsRepo;
        $this->authGroupService = $authGroupService;
        $this->artistRepo = $artistRepo;
        $this->artistPublisherRepo = $artistPublisherRepo;
        $this->contributorsRepo = $contributorsRepo;
    }

    public function storeNote(NoteStore $objRequest){
        $objLanguage = $this->languagesRepo->find($objRequest->input("language"));
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objTrackNote = $this->trackService->storeNote($objFile->track, $objLanguage, $objRequest->input("note"));

        return ($this->apiReply($objTrackNote, "Note have been added successfully.", RESPONSE::HTTP_OK));
    }

    public function updateNote(NoteUpdate $objRequest){
        $objNote = $this->trackNotesRepo->find($objRequest->input("note"));
        $boolResult = $this->checkFilePermission($objNote->track->file);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->trackService->updateNote($objNote, $objRequest->input("note_text"));

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Note have been updated successfully.", Response::HTTP_OK));
    }

    public function deleteNote(NoteDelete $objRequest){
        $objNote = $this->trackNotesRepo->find($objRequest->input("note"));
        $boolResult = $this->checkFilePermission($objNote->track->file);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->trackService->deleteNote($objNote);

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Note have been deleted successfully.", Response::HTTP_OK));
    }

    public function storeLyrics(LyricsStore $objRequest){
        $objLanguage = $this->languagesRepo->find($objRequest->input("language"));
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }


        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objTrackLyrics = $this->trackService->storeLyrics($objFile->track, $objLanguage, $objRequest->input("lyrics"));

        return ($this->apiReply($objTrackLyrics, "Lyrics have been added successfully.", RESPONSE::HTTP_OK));
    }

    public function updateLyrics(LyricsUpdate $objRequest){
        $objLyrics = $this->trackLyricsRepo->find($objRequest->input("lyrics"));
        $boolResult = $this->checkFilePermission($objLyrics->track->file);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->trackService->updateLyrics($objLyrics, $objRequest->input("lyrics_text"));

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Lyrics have been updated successfully.", Response::HTTP_OK));
    }

    public function deleteLyrics(LyricsDelete $objRequest){
        $objLyrics = $this->trackLyricsRepo->find($objRequest->input("lyrics"));
        $boolResult = $this->checkFilePermission($objLyrics->track->file);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->trackService->deleteLyrics($objLyrics);

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Lyrics have been deleted successfully.", Response::HTTP_OK));
    }

    public function storeArtist(ArtistsStore $objRequest){
        $objUser = Auth::user();
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objArtist = $this->artistRepo->find($objRequest->input("artist"));

        if (is_null($objArtist)) {
            return ($this->apiReject(null, "Artist not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objTrack = $this->trackService->storeArtist($objFile->track, $objArtist, $objUser->user_id, $objRequest->input("type"));

        return ($this->apiReply($objTrack->artists, "Artist stored successfully.", Response::HTTP_OK));
    }

    public function deleteArtist(ArtistDelete $objRequest){
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objArtist = $this->artistRepo->find($objRequest->input("artist"));

        if (is_null($objArtist)) {
            return ($this->apiReject(null, "Artist not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objTrack = $this->trackService->deleteArtist($objFile->track, $objArtist);

        return ($this->apiReply($objTrack->artists, "Artist deleted successfully.", Response::HTTP_OK));
    }

    public function storePublisher(PublisherStore $objRequest){
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objPublisher = $this->artistPublisherRepo->find($objRequest->input("publisher"));
        $objTrack = $this->trackService->storePublisher($objFile->track, $objPublisher, Auth::user()->user_id);

        return ($this->apiReply($objTrack->publisher, "Publisher added successfully.", Response::HTTP_OK));
    }

    public function deletePublisher(PublisherStore $objRequest){
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objPublisher = $this->artistPublisherRepo->find($objRequest->input("publisher"));
        $objTrack = $this->trackService->deletePublisher($objFile->track, $objPublisher);

        return ($this->apiReply($objTrack->publisher, "Publisher deleted successfully.", Response::HTTP_OK));
    }

    public function storeContributor(ContributorStore $objRequest){
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objContributor = $this->contributorsRepo->find($objRequest->input("type"));
        $objTrack = $this->trackService->storeContributor($objFile->track, $objContributor, Auth::user()->user_id, $objRequest->input("contributor"));

        return ($this->apiReply($objTrack->contributors, "Contributor added successfully.", Response::HTTP_OK));
    }

    public function deleteContributor(ContributorStore $objRequest){
        $objFile = $this->fileRepo->find($objRequest->input("file"));
        $boolResult = $this->checkFilePermission($objFile);

        if (!$boolResult) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objFile->track)) {
            return ($this->apiReject(null, "Track not found.", RESPONSE::HTTP_BAD_REQUEST));
        }

        $objContributor = $this->contributorsRepo->find($objRequest->input("type"));
        $objTrack = $this->trackService->deleteContributor($objFile->track, $objContributor);

        return ($this->apiReply($objTrack->contributors, "Contributor deleted successfully.", Response::HTTP_OK));
    }

    private function checkFilePermission($objFile){
        $objUser = Auth::user();
        $strService = $objFile->collections[0]->project->account->account_uuid;
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $strService)->first();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $strService)->first();

        $bnSoundblock = is_authorized(
            $objUser,
            $this->authGroupService->findByProject($objFile->collections[0]->project)->group_name,
            "App.Soundblock.Project.File.Music.Update",
            "soundblock"
        );

        if ((is_null($objAccount) && is_null($objOwnAccount)) || !$bnSoundblock) {
            return (false);
        }

        return (true);
    }
}
