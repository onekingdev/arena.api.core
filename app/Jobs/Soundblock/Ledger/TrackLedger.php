<?php

namespace App\Jobs\Soundblock\Ledger;

use Carbon\Carbon;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Soundblock\Track as TrackModel;
use App\Events\Soundblock\Ledger\ProjectLedger as ProjectLedgerEvent;
use App\Services\Soundblock\Ledger\TrackLedger as TrackLedgerService;

class TrackLedger 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var TrackModel */
    private TrackModel $objTrack;
    private array $arrHistoryChanges;
    private string $strEvent;

    /**
     * Create a new job instance.
     *
     * @param TrackModel $objTrack
     * @param string $strEvent
     * @param array $arrHistoryChanges
     */
    public function __construct(TrackModel $objTrack, string $strEvent, array $arrHistoryChanges = [])
    {
        $this->objTrack = $objTrack;
        $this->strEvent = $strEvent;
        $this->arrHistoryChanges = $arrHistoryChanges;
    }

    /**
     * Execute the job.
     *
     * @param TrackLedgerService $ledgerService
     * @return void
     */
    public function handle(TrackLedgerService $ledgerService)
    {
        $objProject = $this->objTrack->file->collections[0]->project;

        if (is_null($objProject)) {
            throw new \Exception("Invalid Project.");
        }

        $objCreatedBy = $this->objTrack->createdBy;
        $objUpdatedBy = $this->objTrack->updatedBy;

        $arrFileData = [
            "Account ID"    => $objProject->account->account_uuid,
            "Project ID"    => $objProject->project_uuid,
            "Project Title" => $objProject->project_title,
            "Track ID"      => $this->objTrack->track_uuid,
            "File ID"       => $this->objTrack->file_uuid,
            "Filename"      => $this->objTrack->file->file_name,
            "Title"         => $this->objTrack->file->file_title,
            "Created At"    => Carbon::parse($this->objTrack->stamp_created_at)->format("F j, Y h:i:s A") . " (UTC)",
            "Created By"    => "$objCreatedBy->name <{$objCreatedBy->primary_email->user_auth_email}>",
        ];

        $objLedger = $this->objTrack->ledger;

        if (is_null($objLedger)) {
            $arrFileData["Track Metadata"] = [
                "Track Number"                => $this->objTrack->track_number,
                "Track Duration"              => $this->objTrack->track_duration,
                "Track ISRC"                  => $this->objTrack->track_isrc,
                "Track Artist"                => $this->objTrack->track_artist,
                "Track Version"               => $this->objTrack->track_version,
                "Copyright Name"              => $this->objTrack->copyright_name,
                "Copyright Year"              => $this->objTrack->copyright_year,
                "Recording Location"          => $this->objTrack->recording_location,
                "Recording Year"              => $this->objTrack->recording_year,
                "Track Language ID"           => $this->objTrack->track_language_uuid,
                "Track Language Vocals ID"    => $this->objTrack->track_language_vocals_uuid,
                "Track Volume Number"         => $this->objTrack->track_volume_number,
                "Track Release Date"          => $this->objTrack->track_release_date,
                "Country Recording"           => $this->objTrack->country_recording,
                "Country Commissioning"       => $this->objTrack->country_commissioning,
                "Rights Holder"               => $this->objTrack->rights_holder,
                "Rights Owner"                => $this->objTrack->rights_owner,
                "Rights Contract"             => $this->objTrack->rights_contract,
                "Flag Track Explicit"         => $this->objTrack->flag_track_explicit,
                "Flag Track Instrumental"     => $this->objTrack->flag_track_instrumental,
                "Flag Allow Preorder"         => $this->objTrack->flag_allow_preorder,
                "Flag Allow Preorder Preview" => $this->objTrack->flag_allow_preorder_preview,
                "Preview Start"               => $this->objTrack->preview_start,
                "Preview Stop"                => $this->objTrack->preview_stop,
                "Genre Primary ID"            => $this->objTrack->genre_primary_uuid,
                "Genre Secondary ID"          => $this->objTrack->genre_secondary_uuid,
                "Artists"                     => $this->objTrack->artists,
                "Contributors"                => $this->objTrack->contributors,
                "Publishers"                  => $this->objTrack->publisher,
                "Notes"                       => $this->objTrack->notes,
                "Lyrics"                      => $this->objTrack->lyrics,
            ];

            $objLedger = $ledgerService->createDocument($this->objTrack, $arrFileData, TrackLedgerService::CREATE_EVENT);

            event(new ProjectLedgerEvent($objProject, $objLedger->ledger_uuid, "track", $this->objTrack->track_uuid));
        } else {
            foreach ($this->arrHistoryChanges as $field_name => $arrChangeItem) {
                $arrFileData["Changes"][$field_name] = [
                    "Old value" => $arrChangeItem["Previous value"],
                    "New value" => $arrChangeItem["Changed to"],
                    "Updated At" => Carbon::now()->format("F j, Y h:i:s A") . " (UTC)",
                    "Updated By" => "$objUpdatedBy->name <{$objUpdatedBy->primary_email->user_auth_email}>",
                ];
            }

            $ledgerService->updateDocument($objLedger, $arrFileData, TrackLedgerService::UPDATE_EVENT);
        }
    }
}
