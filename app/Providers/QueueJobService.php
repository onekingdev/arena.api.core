<?php

namespace App\Providers;

use App\Events\Common\QueueStatus;
use Queue;
use Illuminate\Support\ServiceProvider;
use App\Services\Common\QueueJob;
use Illuminate\Queue\Events\{JobFailed, JobProcessed, JobProcessing};

class QueueJobService extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        /** @var QueueJob $queueJobService */
        $queueJobService = app(QueueJob::class);

        Queue::before(function (JobProcessing $event) {
            echo "Before processing time... " . microtime(true) . PHP_EOL;
            echo $event->job->payload()["displayName"] . PHP_EOL;
        });

        // handle the event after the job is processed in the queue.
        Queue::after(function (JobProcessed $event) use ($queueJobService) {
            echo "Processed time... " . microtime(true) . PHP_EOL;
            $job = $event->job;

            $jobId = $job->getJobId();

            if (is_int($jobId)) {
                $queueJob = $queueJobService->findByJobId($jobId);

                if ($queueJob) {
                    $queueJob->released();
                    $arrPendingJobs = $queueJobService->getPendingJobsByStatus($queueJob->job_type);

                    foreach ($arrPendingJobs as $objJob) {
                        event(new QueueStatus($objJob));
                    }
                }
            }
        });

        // For handling the failed jobs in the future...
        Queue::failing(function (JobFailed $event) use ($queueJobService) {
            $job = $event->job;

            $jobId = $job->getJobId();

            if (is_int($jobId)) {
                $queueJob = $queueJobService->findByJobId($jobId);
                echo "Job failed" . PHP_EOL;

                if ($queueJob) {
                    $queueJob->failed();

                    $arrPendingJobs = $queueJobService->getPendingJobsByStatus($queueJob->job_type);

                    foreach ($arrPendingJobs as $objJob) {
                        event(new QueueStatus($objJob));
                    }
                }
            }

        });
    }
}
