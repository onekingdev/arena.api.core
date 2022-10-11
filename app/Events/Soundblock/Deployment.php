<?php

namespace App\Events\Soundblock;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Soundblock\Projects\Deployments\Deployment as DeploymentModel;

class Deployment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var DeploymentModel
     */
    public DeploymentModel $objDeployment;

    /**
     * Create a new event instance.
     *
     * @param DeploymentModel $objDeployment
     */
    public function __construct(DeploymentModel $objDeployment)
    {
        $this->objDeployment = $objDeployment;
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
