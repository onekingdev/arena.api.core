<?php

namespace App\Jobs\Music;

use App\Contracts\File\Zip;
use App\Helpers\Util;
use App\Models\Music\Project\ProjectDraftVersion;
use App\Support\Files\Wav;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnzipDraft implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var ProjectDraftVersion
     */
    private ProjectDraftVersion $projectDraftVersion;

    /**
     * Create a new job instance.
     *
     * @param ProjectDraftVersion $projectDraftVersion
     */
    public function __construct(ProjectDraftVersion $projectDraftVersion) {
        $this->projectDraftVersion = $projectDraftVersion;
    }

    /**
     * Execute the job.
     *
     * @param Zip $zipContract
     * @return void
     */
    public function handle(Zip $zipContract) {
        if (!isset($this->projectDraftVersion->draft_json["tracks"])) {
            return;
        }

        $objTracks = collect($this->projectDraftVersion->draft_json["tracks"]);
        $arrTracks = $objTracks->pluck("uuid", "original_name")->toArray();
        info($arrTracks);
        $zipContract->unzip(Util::make_draft_version_zip_path($this->projectDraftVersion), [Wav::class, "filter"],
            Util::make_music_drafts_tracks_path($this->projectDraftVersion->draft), $arrTracks);
    }
}
