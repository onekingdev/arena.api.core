<?php

namespace App\Jobs\Music;

use App\Contracts\File\Zip;
use App\Helpers\Filesystem\Music;
use App\Helpers\Util;
use App\Models\Music\Project\Project;
use App\Models\Music\Project\ProjectDraftVersion;
use App\Support\Files\Wav;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnzipProjectZip implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 240;
    /**
     * @var Project
     */
    private Project $objProject;
    private string $strZipPath;
    private array $arrTracks;

    /**
     * Create a new job instance.
     *
     * @param Project $objProject
     * @param string $strZipPath
     * @param array $arrTracks
     */
    public function __construct(Project $objProject, string $strZipPath, array $arrTracks) {
        $this->objProject = $objProject;
        $this->strZipPath = $strZipPath;
        $this->arrTracks = $arrTracks;
    }

    /**
     * Execute the job.
     *
     * @param Zip $zipContract
     * @return void
     */
    public function handle(Zip $zipContract) {
        $objTracks = collect($this->arrTracks);
        $arrTracks = $objTracks->pluck("uuid", "original_name")->toArray();

        $arrFiles = $zipContract->unzip($this->strZipPath, [Wav::class, "filter"], Music::project_original_tracks_path($this->objProject),
            $arrTracks);

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
                    "job_status"   => strtolower($arrJobData["Job"]["Status"]),
                ]);
            } catch (\Exception $exception) {
                info($exception->getMessage());
            }
        }

        dispatch(new ProjectCompleteTracks($this->objProject));
    }
}
