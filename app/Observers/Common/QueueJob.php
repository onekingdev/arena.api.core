<?php

namespace App\Observers\Common;

use App\Events\Common\QueueStatus;
use Util;
use App\Models\Common\QueueJob as QueueJobModel;

class QueueJob {

    /**
     * @param QueueJobModel $objQueueJob
     * @return void
     */
    public function released(QueueJobModel $objQueueJob) {
        $objQueueJob->{QueueJobModel::STOP_AT} = Util::now();
        $objQueueJob->{QueueJobModel::STAMP_STOP} = microtime(true);
        $objQueueJob->flag_status = "Succeeded";
        $objQueueJob->job_seconds = round($objQueueJob->{QueueJobModel::STAMP_STOP} - $objQueueJob->{QueueJobModel::STAMP_START});

        $objQueueJob->save();

        event(new QueueStatus($objQueueJob));

    }

    /**
     * @param QueueJobModel $objQueueJob
     * @return void
     */
    public function failed(QueueJobModel $objQueueJob) {
        $objQueueJob->flag_status = "Failed";
        $objQueueJob->save();

        event(new QueueStatus($objQueueJob));
    }
}
