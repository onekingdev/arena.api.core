<?php

namespace App\Jobs\Soundblock\Projects\Deployemnts;

use App\Models\Common\QueueJob;
use App\Models\Soundblock\Collections\Collection;
use App\Services\Common\QueueJob as QueueJobService;
use App\Services\Common\Zip as ZipService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Zip implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;
    /**
     * @var Collection
     */
    private Collection $collection;
    /**
     * @var QueueJob
     */
    private QueueJob $queueJob;

    /**
     * Create a new job instance.
     *
     * @param Collection $collection
     * @param QueueJob $queueJob
     */
    public function __construct(Collection $collection, QueueJob $queueJob) {
        $this->collection = $collection;
        $this->queueJob = $queueJob;
    }

    /**
     * Execute the job.
     *
     * @param ZipService $zipService
     * @param QueueJobService $qjService
     * @return void
     */
    public function handle(ZipService $zipService, QueueJobService $qjService) {
        $queueJobParams = [
            "queue_id" => is_null($this->job) ? null : $this->job->getJobId(),
            "job_name" => is_null($this->job) ? null : $this->job->payload()["displayName"],
        ];

        $queueJob = $qjService->update($this->queueJob, $queueJobParams);

        $strPath = $zipService->zipMusic($this->collection);

        if ($strPath) {
            $queueJob = $qjService->update($queueJob, [
                "job_json" => [
                    "path" => $strPath,
                ],
            ]);
        }
    }
}
