<?php

namespace App\Repositories\Common;

use Util;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection as SupportCollection;
use App\Models\{Users\User, Common\QueueJob as QueueJobModel};

class QueueJob extends BaseRepository {
    /**
     * @param QueueJobModel $queueJob
     * @return void
     */
    public function __construct(QueueJobModel $queueJob) {
        $this->model = $queueJob;
    }

    public function find($id, bool $bnFailure = false) {
        if ($bnFailure) {
            if (is_int($id)) {
                return ($this->model->lockForUpdate()->findOrFail($id));
            } else if (Util::is_uuid($id)) {
                return ($this->model->lockForUpdate()->where($this->model->uuid(), $id)->firstOrFail());
            }
        } else {
            if (is_int($id)) {
                return ($this->model->lockForUpdate()->find($id));
            } else if (Util::is_uuid($id)) {
                return ($this->model->lockForUpdate()->where($this->model->uuid(), $id)->first());
            }
        }
    }

    /**
     * @param int $job
     * @param bool $bnFailure
     * @return QueueJobModel|null
     */
    public function findByJobId(int $job, bool $bnFailure = false): ?QueueJobModel {
        $query = $this->model->lockForUpdate()->where("queue_id", $job);
        if ($bnFailure) {
            return ($query->first());
        } else {
            return ($query->firstOrFail());
        }
    }

    /**
     * @param array $arrQueueJob
     * @return QueueJobModel
     * @throws \Exception
     */
    public function createModel(array $arrQueueJob): QueueJobModel {
        $model = new QueueJobModel;
        $uuid = $this->model->uuid();
        if (!isset($arrQueueJob[$uuid])) {
            $arrQueueJob[$uuid] = Util::uuid();
        }
        $model->fill($arrQueueJob);
        $model->save();

        return ($model);
    }

    /**
     * @param int $intQueue
     * @param bool|null $bnFailure
     * @return QueueJobModel
     */
    public function findByQueue(int $intQueue, ?bool $bnFailure = true): QueueJobModel {
        if ($bnFailure) {
            return ($this->model->where("queue_id", $intQueue)->firstOrFail());
        } else {
            return ($this->model->where("queue_id", $intQueue)->first());
        }
    }

    /**
     * @param User|null $user
     * @return SupportCollection
     */
    public function findAllPending(?User $user = null): SupportCollection {
        $now = microtime(true);
        if ($user) {
            return ($user->jobs()->where("flag_status", "Pending")->whereRaw("$now - stamp_start < 7200")->get());
        }

        return ($this->model->where("flag_status", "Pending")->whereRaw("$now - stamp_start < 7200")->get());
    }

    /**
     * @param User|null $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllRunning(?User $user = null) {
        $now = microtime(true);
        if ($user) {
            return ($user->jobs()->whereNotNull("queue_id")->where("flag_status", "Pending")
                         ->where(function ($query) use ($now) {
                             $query->whereRaw("$now - stamp_start <= 7200")
                                   ->orWhereRaw("$now -stamp_start >= 0");
                         })->get());
        } else {
            return ($this->model->whereNotNull("queue_id")->where("flag_status", "Pending")
                                ->where(function ($query) use ($now) {
                                    $query->whereRaw("$now - stamp_start <= 7200")
                                          ->orWhereRaw("$now -stamp_start >= 0");
                                })->get());
        }
    }

    /**
     * @param QueueJobModel|null $objQueueJob
     * @return array
     */
    public function findPendingJobType(QueueJobModel $objQueueJob = null): array {
        $now = microtime(true);
        $query = $this->model->whereNotNull("job_type")->where("job_type", $objQueueJob->job_type)->where(function ($query) use ($now) {
            $query->whereRaw("$now - stamp_start <= 7200")
               ->orWhereRaw("$now - stamp_start >= 0");
        })->where("flag_status", "Pending")->groupBy("job_type");

        if ($objQueueJob) {
            $query = $query->where(QueueJobModel::STAMP_START, "<=", $objQueueJob->{QueueJobModel::STAMP_START});
        }

        return ($query->get()->pluck("job_type")->toArray());
    }

    /**
     * @return array
     */
    public function findPendingJobTypeForEstimate(): array {
        $query = $this->model->whereNotNull("job_name")
            ->where("flag_status", "Pending")
            ->groupBy("job_type");

        return ($query->get()->pluck("job_type")->toArray());
    }

    public function findAllAhead(QueueJobModel $objJob, ?string $strJobType = null) {
        $query = $this->model->whereNotNull("job_name")->where("flag_status", "Pending");

        if ($strJobType && $objJob->job_type) {
            $query = $query->where("job_type", $strJobType);
        }

        return ($query->get());
    }

    public function getAvgJobTime($strJobType){
        return (round($this->model->whereNotNull("job_name")
            ->whereNotNull("job_seconds")
            ->where("flag_status", "Succeeded")
            ->where("job_type", $strJobType)
            ->where("job_seconds", "<", 120)
            ->avg("job_seconds")));
    }

    /**
     * @param string $strJobType
     * @return int
     */
    public function getCountPendingJob(string $strJobType): int {
        $now = microtime(true);
        return ($this->model->whereRaw("lower(flag_status) = (?)", Util::lowerLabel("Pending"))
                            ->whereRaw("lower(job_type) = (?)", Util::lowerLabel($strJobType))
                            ->where(function ($query) use ($now) {
                                $query->whereRaw("$now - stamp_start <= 7200")
                                      ->orWhereRaw("$now - stamp_start >= 0");
                            })
                            ->count());
    }

    /**
     * @param string $strJobType
     * @return int
     */
    public function getAvgTime(?string $strJobType = null): int {
        $query = $this->model->whereNotNull("queue_id")
                             ->whereRaw("lower(flag_status) = (?)", Util::lowerLabel("Succeeded"));
        if ($strJobType) {
            $query = $query->whereRaw("lower(job_type) = (?)", Util::lowerLabel($strJobType));
        }

        return (round($query->avg("job_seconds")));
    }

    public function getJobsForDownload() {
        return $this->model->where("flag_remove_file", true)->get();
    }

    public function getJobsByStatus(string $strType) {
        $now = microtime(true);

        return ($this->model->where("flag_status", "Pending")->where("job_type", $strType)
            ->whereRaw("$now - stamp_start < 7200")->get());
    }
}
