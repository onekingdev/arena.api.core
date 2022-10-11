<?php

namespace App\Events\Office;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Soundblock\Projects\Deployments\Deployment;

class UpdateDeployment {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Deployment $objDeployment;

    /**
     * Create a new event instance.
     *
     * @param Deployment $objDeployment
     */
    public function __construct(Deployment $objDeployment) {
        $this->objDeployment = $objDeployment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
