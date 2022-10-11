<?php

namespace App\Broadcasting\Common;

use Log;
use App\Models\Users\User;
use App\Services\Common\QueueJob;

class JobChannel {
    /**
     * @var QueueJob
     */
    private QueueJob $queueJob;

    /**
     * Create a new channel instance.
     *
     * @param QueueJob $queueJob
     */
    public function __construct(QueueJob $queueJob) {
        $this->queueJob = $queueJob;
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $objUser
     * @param string $job
     * @return array|bool
     */
    public function join(User $objUser, string $job) {
        $objJob = $this->queueJob->find($job, false);

        if (is_null($objJob)) {
            return false;
        }

        return ($objJob->user_uuid == $objUser->user_uuid);
    }
}
