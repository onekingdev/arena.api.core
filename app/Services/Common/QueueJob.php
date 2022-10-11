<?php

namespace App\Services\Common;

use Util;
use Auth;
use Queue;
use Client;
use Builder;
use Exception;
use Illuminate\Support\Collection;
use App\Repositories\User\UserAlias;
use App\Events\Common\PrivateNotification;
use App\Repositories\Common\QueueJob as QueueJobRepository;
use App\Models\{Common\QueueJob as QueueJobModel, Users\User};

class QueueJob {
    /** @var QueueJobRepository */
    protected QueueJobRepository $queueJobRepo;
    /** @var UserAlias $aliasRepo */
    protected UserAlias $aliasRepo;

    /**
     * @param QueueJobRepository $queueJobRepo
     * @param UserAlias $aliasRepo
     * @return void
     */
    public function __construct(QueueJobRepository $queueJobRepo, UserAlias $aliasRepo) {
        $this->queueJobRepo = $queueJobRepo;
        $this->aliasRepo = $aliasRepo;
    }

    /**
     * @param string/int $id
     * @param bool $bnFailure
     * @return QueueJobModel
     */
    public function find($id, ?bool $bnFailure = true) {
        return ($this->queueJobRepo->find($id, $bnFailure));
    }

    /**
     * @param int $job
     * @param bool $bnFailure
     * @return QueueJobModel
     */
    public function findByJobId(int $job, bool $bnFailure = false): ?QueueJobModel {
        return ($this->queueJobRepo->findByJobId($job, $bnFailure));
    }

    public function findByQueue(int $intQueue, ?bool $bnFailure = true) {
        return ($this->queueJobRepo->findByQueue($intQueue, $bnFailure));
    }

    /**
     * @param User|null $objUser
     * @return Collection
     */
    public function findAllPending(?User $objUser = null): Collection {
        if (is_null($objUser))
            $objUser = Auth::user();
        return ($this->queueJobRepo->findAllPending($objUser));
    }

    /**
     * @param User|null $user
     * @return Collection
     */
    public function findAllRunning(?User $user = null): Collection {
        if (is_null($user)) {
            /** @var User */
            $user = Auth::user();
        }
        return ($this->queueJobRepo->findAllRunning($user));
    }

    protected function getEstimatedTime(): int {
        if ($this->queueJobRepo->getAvgTime() != 0) {
            $avgTime = $this->queueJobRepo->getAvgTime();
        } else {
            $avgTime = 8;
        }

        return ($avgTime);
    }

    public function getPendingJobsByStatus(string $strStatus) {
        return ($this->queueJobRepo->getJobsByStatus($strStatus));
    }

    public function getJobsForRemove() {
        return $this->queueJobRepo->getJobsForDownload();
    }

    /**
     * @param string $job
     * @return mixed
     * @throws Exception
     */
    public function getStatus(string $job) {
        $arrStatus = [];
        $queueJob = $this->find($job);

        if ($queueJob->flag_status == "Failed") {
            $jobContent = $queueJob->job_json;

            $arrStatus = [
                "job"           => $queueJob->makeHidden(["queue_id"]),
                "estimate_time" => $queueJob->flag_status == "Succeeded" ? 0 : $this->estimateTime($queueJob),
                "unit"          => "second",
                "position"      => $this->getPosition($queueJob),
                "message"       => $jobContent["exception"]["message"],
                "code"          => $jobContent["exception"]["code"],
            ];

            return ($arrStatus);
        } else {
            $arrStatus = [
                "job"           => $queueJob->makeHidden(["queue_id"]),
                "estimate_time" => $queueJob->flag_status == "Succeeded" ? 0 : $this->estimateTime($queueJob),
                "unit"          => "second",
                "position"      => $this->getPosition($queueJob),
            ];

            if ($queueJob->flag_status == "Pending") {
                $arrStatus = array_merge($arrStatus, ["queue_size" => $this->getQueueSize()]);
            }

            return ($arrStatus);
        }
    }

    /**
     * @param QueueJobModel $objQueueJob
     * @param int|null $intThreads
     * @return int
     */
    public function getPosition(QueueJobModel $objQueueJob, ?int $intThreads = 1): int {
        $count = $this->queueJobRepo->findAllAhead($objQueueJob, $objQueueJob->job_type)->count() + 1;
        return (round($count / $intThreads));
    }

    /**
     * @param string $strQueueName
     * @return int
     */
    public function getQueueSize(string $strQueueName = "default") {
        return (Queue::size($strQueueName));
    }

    /**
     * @return array
     */
    public function getJobsStatus(): array {
        $arrStatus = [
            "pending_jobs"  => $this->findAllPending(),
            "running_jobs"  => $this->findAllRunning(),
            "estimate_time" => $this->estimateAllTime(),
            "queue_size"    => $this->getQueueSize(),
        ];
        return ($arrStatus);
    }

    /**
     * @param array $arrParams
     * @return QueueJobModel
     * @throws Exception
     */
    public function create(array $arrParams): QueueJobModel {
        $arrQueueJob = [];
        if (!Util::array_keys_exists(["queue_id", "job_type", "job_name"], $arrParams))
            throw new Exception("Must have following properties queue_id, job_type, job_name", 417);

        $arrQueueJob["queue_id"] = $arrParams["queue_id"];
        $arrQueueJob["job_type"] = $arrParams["job_type"];
        $arrQueueJob["job_name"] = $arrParams["job_name"];

        if (isset($arrParams["user_id"]) && isset($arrParams["user_uuid"])) {
            $arrQueueJob["user_id"] = $arrParams["user_id"];
            $arrQueueJob["user_uuid"] = $arrParams["user_uuid"];
        }

        $arrQueueJob["job_json"] = [
            "project"      => "",
            "download_url" => "",
        ];

        if (isset($arrParams["job_memo"])) {
            $arrQueueJob["job_memo"] = $arrParams["job_memo"];
        } else {
            // default...
        }
        if (isset($arrParams["job_script"])) {
            $arrQueueJob["job_script"] = $arrParams["job_script"];
        } else {
            // default...
        }
        if (isset($arrParams["flag_status"])) {
            $arrQueueJob["flag_status"] = $arrParams["flag_status"];
        } else {
            $arrQueueJob["flag_status"] = "Pending";
        }

        if (isset($arrParams["flag_silentalert"])) {
            $arrQueueJob["flag_silentalert"] = $arrParams["flag_silentalert"];
        } else {
            $arrQueueJob["flag_silentalert"] = 1;
        }

        return ($this->queueJobRepo->createModel($arrQueueJob));
    }

    private function makeException(string $message, string $code) {
        $exception = new Exception($message, $code);
        throw $exception;
    }

    /**
     * @param QueueJobModel $objQueueJob
     * @param int
     * @return int
     */
    public function estimateTime(QueueJobModel $objQueueJob, ?int $intThreads = 1) {
        $arrPendingJobTypes = $this->queueJobRepo->findPendingJobTypeForEstimate();
        $estimateTime = 0;

        foreach ($arrPendingJobTypes as $jobType) {
            $avgTime = $this->queueJobRepo->getAvgJobTime($jobType);
            if ($avgTime == 0) {
                $avgTime = $this->getEstimatedTime();
            }
            $count = $this->queueJobRepo->findAllAhead($objQueueJob, $jobType)->count();
            $estimateTime += $avgTime * $count / $intThreads;
        }

        if ($estimateTime == 0) {
            $estimateTime = $this->getEstimatedTime();
        }

        return ($estimateTime);
    }

    /**
     * @param int|null $intThreads
     * @return int $estimateTime
     */
    public function estimateAllTime(?int $intThreads = 1) {
        $arrPendingJobTypes = $this->queueJobRepo->findPendingJobType();
        $estimateTime = 0;

        foreach ($arrPendingJobTypes as $jobType) {
            $avgTime = $this->queueJobRepo->getAvgTime($jobType);
            $count = $this->queueJobRepo->getCountPendingJob($jobType);
            $estimateTime += $avgTime * $count / $intThreads;
        }

        return ($estimateTime);
    }

    /**
     * @param QueueJobModel $queueJob
     * @param array $arrParams
     * @return QueueJobModel
     */
    public function update(QueueJobModel $queueJob, array $arrParams) {
        $updatableFields = ["flag_silentalert", "queue_id", "job_type", "job_name", "job_json"];
        $arrQueueJob = collect($arrParams)->only($updatableFields)->toArray();
        if (isset($arrParams["flag_silentalert"]) && $arrParams["flag_silentalert"] == 0)
            $this->notify($queueJob);

        return ($this->queueJobRepo->update($queueJob, $arrQueueJob));
    }

    /**
     * @param QueueJobModel $queueJob
     * @return void
     */
    protected function notify(QueueJobModel $queueJob) {
        if (!$queueJob->flag_status == "Succeeded")
            return;
        $jobContents = $queueJob->job_json;
        $flags = [
            "notification_state" => "unread",
            "flag_canarchive"    => true,
            "flag_candelete"     => true,
            "flag_email"         => false,
        ];

        if (isset($jobContents["project"])) {
            $contents = $this->notifyExtractProject($queueJob);
        } else if (isset($jobContents["download"])) {
            $contents = $this->notifyZipFiles($queueJob);
        } else {
            return;
        }

        event(new PrivateNotification($queueJob->user, $contents, $flags, Client::app()));
    }

    /**
     * @param QueueJobModel $queueJob
     * @return array
     */
    protected function notifyExtractProject(QueueJobModel $queueJob) {
        $alias = $this->aliasRepo->findPrimary($queueJob->user);
        $contents = [
            "notification_name"   => "Extract Files",
            "notification_memo"   => "All files are extracted.",
            "notification_action" => Builder::notification_button("OK"),
            "message"             => sprintf("Mr %s All files zipped.", $alias->user_alias),
            "alias"               => $alias->user_alias,
        ];

        return ($contents);
    }

    /**
     * @param QueueJobModel $queueJob
     * @return array
     */
    protected function notifyZipFiles(QueueJobModel $queueJob): array {
        $alias = $this->aliasRepo->findPrimary($queueJob->user);
        $jobContents = $queueJob->job_json;
        $contents = [
            "notification_name"   => "Hello",
            "notification_memo"   => "All files zipped successfully.",
            "notification_action" => Builder::notification_link(["url" => $jobContents["download"], "link_name" => "Download"]),
            "message"             => sprintf("Mr %s All files zipped.", $alias->user_alias),
            "alias"               => $alias->user_alias,
        ];

        return ($contents);
    }
}
