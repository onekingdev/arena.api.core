<?php

namespace App\Events\Soundblock;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Soundblock\Projects\Deployments\Deployment;

class DeploymentHistory
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Deployment
     */
    public Deployment $objDeployment;
    public string $status;

    /**
     * Create a new event instance.
     *
     * @param Deployment $objDeployment
     * @param string $status
     */
    public function __construct(Deployment $objDeployment, string $status)
    {
        $this->objDeployment = $objDeployment;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
