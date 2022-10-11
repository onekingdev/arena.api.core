<?php

namespace App\Events\Common;

use App\Models\Common\QueueJob;
use App\Services\Common\QueueJob as QueueJobService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueueStatus implements ShouldBroadcastNow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var QueueJob
     */
    private QueueJob $objQueueJob;
    /**
     * @var mixed
     */
    private $objApp;

    /**
     * Create a new event instance.
     *
     * @param QueueJob $objQueueJob
     */
    public function __construct(QueueJob $objQueueJob) {
        $this->objQueueJob = $objQueueJob;
        $this->objApp = $objQueueJob->app;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel(sprintf("channel.app.%s.job.%s", $this->objApp->app_name, $this->objQueueJob->job_uuid));
    }

    public function broadcastAs() {
        return (sprintf("%s.Job.%s", ucfirst($this->objApp->app_name), $this->objQueueJob->job_uuid));
    }

    public function broadcastWith() {
        /** @var QueueJobService $objJobService */
        $objJobService = resolve(QueueJobService::class);

        return ($objJobService->getStatus($this->objQueueJob->job_uuid));
    }
}
