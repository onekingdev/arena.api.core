<?php

namespace App\Jobs\Soundblock\Projects;

use App\Contracts\Soundblock\Data\IsrcCodes;
use App\Events\Soundblock\FileIsrc as FileIsrcEvent;
use App\Models\Common\QueueJob as QueueJobModel;
use App\Models\Soundblock\Files\File;
use App\Models\Soundblock\Collections\Collection as CollectionModel;
use App\Models\Soundblock\Track;
use App\Services\Common\QueueJob;
use App\Services\Soundblock\Collection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FileIsrc implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Track
     */
    private Track $fileMusic;
    /**
     * @var QueueJobModel
     */
    private QueueJobModel $objQueueJob;

    /**
     * Create a new job instance.
     *
     * @param Track $fileMusic
     * @param QueueJobModel $objQueueJob
     */
    public function __construct(Track $fileMusic, QueueJobModel $objQueueJob) {
        $this->fileMusic = $fileMusic;
        $this->objQueueJob = $objQueueJob;
    }

    /**
     * Execute the job.
     *
     * @param QueueJob $queueJobService
     * @param IsrcCodes $isrcServices
     * @return void
     * @throws \Exception
     */
    public function handle(QueueJob $queueJobService, IsrcCodes $isrcServices) {
        if (!$this->job) {
            throw new \Exception("Something went wrong", 417);
        }

        $queueJobParams = [
            "queue_id" => empty($this->job->getJobId()) ? null : $this->job->getJobId(),
            "job_name" => is_null($this->job) ? null : $this->job->payload()["displayName"],
            "job_json" => ["file" => $this->fileMusic->file_uuid],
        ];

        $queueJobService->update($this->objQueueJob, $queueJobParams);

        $objIsrc = $isrcServices->getUnused();

        $this->fileMusic->track_isrc = $objIsrc->data_isrc;
        $this->fileMusic->save();

        $isrcServices->useIsrc($objIsrc);

        /** @var File $objFile */
        $objFile = $this->fileMusic->file;
        /** @var CollectionModel $objCollection */
        $objCollection = $objFile->collections()->first();
        $objProject = $objCollection->project;

        event(new FileIsrcEvent($objFile, $objProject));
    }
}
