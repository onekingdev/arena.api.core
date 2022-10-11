<?php

namespace App\Http\Controllers\Soundblock;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Contracts\Soundblock\Artist\Artist as ArtistService;
use App\Http\Requests\Soundblock\Artist\{
    GetArtist,
    StoreArtist,
    UpdateArtist,
    DeleteArtist,
    GetArtistPublisher,
    DeleteArtistPublisher,
    StoreArtistPublisher,
    UpdateArtistPublisher,
};
use App\Jobs\Soundblock\Ledger\TrackLedger;
use App\Contracts\Soundblock\Audit\Bandwidth;
use App\Jobs\Soundblock\Ledger\ProjectLedger;
use App\Repositories\Soundblock\Project as ProjectRepository;
use App\Repositories\Soundblock\TrackHistory as TrackHistoryRepository;

/**
 * @group Soundblock
 *
 * Soundblock artist
 */
class Artist extends Controller
{
    /** @var ArtistService */
    private ArtistService $artistService;
    /** @var Bandwidth */
    private Bandwidth $bandwidthService;
    /** @var ProjectRepository */
    private ProjectRepository $projectRepo;
    /** @var TrackHistoryRepository */
    private TrackHistoryRepository $trackHistoryRepo;

    /**
     * Artist constructor.
     * @param ArtistService $artistService
     * @param Bandwidth $bandwidthService
     * @param ProjectRepository $projectRepo
     * @param TrackHistoryRepository $trackHistoryRepo
     */
    public function __construct(ArtistService $artistService, Bandwidth $bandwidthService, ProjectRepository $projectRepo,
                                TrackHistoryRepository $trackHistoryRepo){
        $this->artistService = $artistService;
        $this->bandwidthService = $bandwidthService;
        $this->projectRepo = $projectRepo;
        $this->trackHistoryRepo = $trackHistoryRepo;
    }

    /**
     * @param GetArtist $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function index(GetArtist $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if ($objRequest->has("artist")) {
            $objArtist = $this->artistService->findByUuid($objRequest->input("artist"));

            if (is_null($objArtist)) {
                return ($this->apiReject(null, "Artist not found.", Response::HTTP_BAD_REQUEST));
            }

            if ($objArtist->account_uuid != $objRequest->input("account")) {
                return ($this->apiReject(null, "Account doesn't have this artist.", Response::HTTP_FORBIDDEN));
            }

            return ($this->apiReply($objArtist, "", Response::HTTP_OK));
        }

        $objArtists = $this->artistService->findAllByAccount($objRequest->input("account"));

        return ($this->apiReply($objArtists, "", Response::HTTP_OK));
    }

    /**
     * @param StoreArtist $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function store(StoreArtist $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objAccount)) {
            $objAccount = $objOwnAccount;
        }

        $objArtist = $this->artistService->create($objRequest->only("artist_name", "url_apple", "url_spotify", "url_soundcloud"), $objAccount);

        if ($objRequest->has("avatar") && $objRequest->has("project_uuid")) {
            $objProject = $this->projectRepo->find($objRequest->input("project_uuid"));
            $this->artistService->uploadAvatar($objRequest->file("avatar"), $objArtist);
            $this->bandwidthService->create($objProject, Auth::user(), $objRequest->file("avatar")->getSize(), Bandwidth::UPLOAD);

            dispatch(new ProjectLedger($objProject, \App\Services\Soundblock\Ledger\ProjectLedger::UPDATE_EVENT))->onQueue("ledger");
        } elseif ($objRequest->has("avatar")) {
            $this->artistService->uploadDraftAvatar($objRequest->file("avatar"), $objArtist);
        }

        return ($this->apiReply($objArtist, "Artist stored successfully.", Response::HTTP_OK));
    }

    /**
     * @param UpdateArtist $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function update(UpdateArtist $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account_uuid"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account_uuid"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account_uuid"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtist = $this->artistService->findByUuid($objRequest->input("artist"));

        if ($objArtist->account_uuid != $objRequest->input("account_uuid")) {
            return ($this->apiReject(null, "Account doesn't have this artist.", Response::HTTP_FORBIDDEN));
        }

        $arrTrackOldArtists = [];
        $objArtistTracks = $objArtist->tracks;

        if (!empty($objArtistTracks)) {
            foreach ($objArtistTracks as $objTrack) {
                $arrTrackOldArtists[$objTrack->track_uuid] = $objTrack->artists->toArray();
            }
        }

        $boolResult = $this->artistService->update($objArtist, $objRequest->only("artist_name", "url_apple", "url_spotify", "url_soundcloud"));

        if ($objRequest->has("avatar") && $objRequest->has("project_uuid")) {
            $objProject = $this->projectRepo->find($objRequest->input("project_uuid"));
            $this->artistService->uploadAvatar($objProject, $objRequest->file("avatar"), $objArtist);
            $this->bandwidthService->create($objProject, Auth::user(), $objRequest->file("avatar")->getSize(), Bandwidth::UPLOAD);

            dispatch(new ProjectLedger($objProject, \App\Services\Soundblock\Ledger\ProjectLedger::UPDATE_EVENT))->onQueue("ledger");
        } else {
            $this->artistService->uploadDraftAvatar($objRequest->file("avatar"), $objArtist);
        }

        if (!empty($objArtistTracks)) {
            foreach ($objArtistTracks as $objTrack) {
                $oldVal = json_encode($arrTrackOldArtists[$objTrack->track_uuid]);
                $newVal = json_encode($objTrack->artists->toArray());
                $this->trackHistoryRepo->create([
                    "track_id" => $objTrack->track_id,
                    "track_uuid" => $objTrack->track_uuid,
                    "field_name" => "artists",
                    "old_value" => $oldVal,
                    "new_value" => $newVal,
                ]);

                dispatch(new TrackLedger($objTrack, \App\Services\Soundblock\Ledger\TrackLedger::UPDATE_EVENT))->onQueue("ledger");
            }
        }

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Artist updated successfully.", Response::HTTP_OK));
    }

    /**
     * @param DeleteArtist $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function delete(DeleteArtist $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtist = $this->artistService->findByUuid($objRequest->input("artist"));

        if ($objArtist->account_uuid != $objRequest->input("account")) {
            return ($this->apiReject(null, "Account doesn't have this artist.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->artistService->delete($objRequest->input("artist"));

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Artist deleted successfully.", Response::HTTP_OK));
    }

    /**
     * @param GetArtistPublisher $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function indexArtistPublisher(GetArtistPublisher $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objAccount)) {
            $objAccount = $objOwnAccount;
        }

        if ($objRequest->has("publisher")) {
            $objPublisher = $this->artistService->findArtistPublisher($objRequest->input("publisher"));

            if (is_null($objPublisher)) {
                return ($this->apiReject(null, "Publisher not found.", Response::HTTP_BAD_REQUEST));
            }

            if ($objPublisher->account_uuid != $objRequest->input("account")) {
                return ($this->apiReject(null, "Account doesn't have this publisher.", Response::HTTP_FORBIDDEN));
            }

            return ($this->apiReply($objPublisher, "", Response::HTTP_OK));
        }

        $objPublishers = $this->artistService->findAllPublisherByAccount($objAccount->account_uuid);

        return ($this->apiReply($objPublishers, "", Response::HTTP_OK));
    }

    /**
     * @param StoreArtistPublisher $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function storeArtistPublisher(StoreArtistPublisher $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objArtist = $this->artistService->findByUuid($objRequest->input("artist"));

        if (optional($objArtist)->account_uuid != $objRequest->input("account")) {
            return ($this->apiReject(null, "Account doesn't have this artist.", Response::HTTP_FORBIDDEN));
        }

        if (is_null($objAccount)) {
            $objAccount = $objOwnAccount;
        }

        $objPublisher = $this->artistService->storeArtistPublisher($objRequest->input("publisher_name"), $objAccount, $objArtist);

        return ($this->apiReply($objPublisher, "Artist publisher created successfully.", Response::HTTP_OK));
    }

    /**
     * @param UpdateArtistPublisher $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function updateArtistPublisher(UpdateArtistPublisher $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objPublisher = $this->artistService->findArtistPublisher($objRequest->input("publisher"));

        if (optional($objPublisher)->account_uuid != $objRequest->input("account")) {
            return ($this->apiReject(null, "Account doesn't have this publisher.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->artistService->updateArtistPublisher($objPublisher, $objRequest->input("publisher_name"));

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Publisher updated successfully.", Response::HTTP_OK));
    }

    /**
     * @param DeleteArtistPublisher $objRequest
     * @return \Illuminate\Http\Resources\Json\ResourceCollection|Response|object
     */
    public function deleteArtistPublisher(DeleteArtistPublisher $objRequest){
        $objUser = Auth::user();
        $objAccount = $objUser->accounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $objOwnAccount = $objUser->userAccounts()->where("soundblock_accounts.account_uuid", $objRequest->input("account"))->first();
        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objRequest->input("account"));

        if (
            !is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Create", "soundblock", true, true) ||
            (is_null($objAccount) && is_null($objOwnAccount))
        ) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objPublisher = $this->artistService->findArtistPublisher($objRequest->input("publisher"));

        if (optional($objPublisher)->account_uuid != $objRequest->input("account")) {
            return ($this->apiReject(null, "Account doesn't have this publisher.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->artistService->deleteArtistPublisher($objPublisher->publisher_uuid);

        if (!$boolResult) {
            return ($this->apiReject(null, "Something went wrong.", Response::HTTP_BAD_REQUEST));
        }

        return ($this->apiReply(null, "Publisher deleted successfully.", Response::HTTP_OK));
    }
}
