<?php

namespace App\Jobs\Music;

use App\Helpers\Filesystem\Music;
use App\Helpers\Util;
use App\Models\Music\Project\Project;
use App\Models\Music\Project\ProjectDraft;
use App\Models\Music\Project\ProjectDraftVersion;
use App\Support\Files\Wav;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranscodeMusic implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Project
     */
    private Project $objProject;
    /**
     * @var ProjectDraft
     */
    private ProjectDraft $objProjectDraft;
    /**
     * @var ProjectDraftVersion
     */
    private ProjectDraftVersion $objVersion;

    /**
     * Create a new job instance.
     *
     * @param Project $objProject
     * @param ProjectDraft $objProjectDraft
     * @param ProjectDraftVersion $objVersion
     */
    public function __construct(Project $objProject, ProjectDraft $objProjectDraft, ProjectDraftVersion $objVersion) {
        $this->objProject = $objProject;
        $this->objProjectDraft = $objProjectDraft;
        $this->objVersion = $objVersion;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle() {
        $arrFiles = bucket_storage("music")->allFiles(Util::make_music_drafts_tracks_path($this->objProjectDraft));
        $arrFiles = Wav::factory($arrFiles, bucket_storage("music"));

        /** @var Wav $objFile */
        foreach ($arrFiles as $objFile) {
            try {
                $strTrackPath = Music::project_track_path($this->objProject, $objFile->getBasicName());
                $arrJobData = $objFile->transcode($strTrackPath);
                $this->objProject->transcoderJobs()->create([
                    "job_uuid"     => Util::uuid(),
                    "project_uuid" => $this->objProject->project_uuid,
                    "aws_job_id"   => $arrJobData["Job"]["Id"],
                    "job_input"    => $arrJobData["Job"]["Inputs"],
                    "job_output"   => $arrJobData["Job"]["Outputs"],
                    "job_status"   => $arrJobData["Job"]["Status"],
                ]);
            } catch (\Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
