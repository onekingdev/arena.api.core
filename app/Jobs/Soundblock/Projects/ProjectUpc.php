<?php

namespace App\Jobs\Soundblock\Projects;

use App\Contracts\Soundblock\Data\UpcCodes;
use App\Events\Soundblock\ProjectUpc as ProjectUpcEvent;
use App\Jobs\Soundblock\Ledger\ProjectLedger;
use App\Models\Common\QueueJob as QueueJobModel;
use App\Services\Common\QueueJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Soundblock\Project as ProjectService;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

class ProjectUpc implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const UPC_INCREMENT_PART = 19999;

    /**
     * @var ProjectModel
     */
    private ProjectModel $objProject;
    /**
     * @var QueueJobModel
     */
    private QueueJobModel $objQueueJob;

    /**
     * Create a new job instance.
     *
     * @param ProjectModel $objProject
     * @param QueueJobModel $objQueueJob
     */
    public function __construct(ProjectModel $objProject, QueueJobModel $objQueueJob) {
        $this->objProject = $objProject;
        $this->objQueueJob = $objQueueJob;
    }

    /**
     * Execute the job.
     *
     * @param QueueJob $queueJobService
     * @param UpcCodes $upcService
     * @return void
     * @throws \Exception
     */
    public function handle(QueueJob $queueJobService, UpcCodes $upcService) {
        if (!$this->job) {
            throw new \Exception("Something went wrong", 417);
        }

        $queueJobParams = [
            "queue_id" => is_null($this->job) ? null : $this->job->getJobId(),
            "job_name" => is_null($this->job) ? null : $this->job->payload()["displayName"],
            "job_json" => ["project" => $this->objProject->project_uuid],
        ];

        $queueJobService->update($this->objQueueJob, $queueJobParams);
        $objUpc = $upcService->getUnused();

        $this->objProject->project_upc = $objUpc->data_upc;
        $this->objProject->save();

        $upcService->useUpc($objUpc);

        event(new ProjectUpcEvent($this->objProject));
        dispatch(new ProjectLedger($this->objProject, \App\Services\Soundblock\Ledger\ProjectLedger::CREATE_EVENT))->onQueue("ledger");
    }
}
