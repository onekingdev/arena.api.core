<?php

namespace App\Events\Soundblock;

use League\Fractal\Manager;
use Illuminate\Queue\SerializesModels;
use League\Fractal\Resource\Collection;
use App\Services\Soundblock\Deployment;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Http\Transformers\Soundblock\Deployment as DeploymentTransformer;

class UpdateDeployments implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Project
     */
    private Project $objProject;

    /**
     * Create a new event instance.
     *
     * @param Project $objProject
     */
    public function __construct(Project $objProject) {
        $this->objProject = $objProject;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.soundblock.project.{$this->objProject->project_uuid}.deployments"));
    }

    public function broadcastAs() {
        return ("Soundblock.Project.{$this->objProject->project_uuid}.Deployments");
    }

    public function broadcastWith() {
        /** @var Deployment $objDeploymentService */
        $objDeploymentService = resolve(Deployment::class);
        $arrDeployments = $objDeploymentService->findAllByProject($this->objProject->project_uuid);
        $collection = $arrDeployments->getCollection();
        $resource = new Collection($collection, new DeploymentTransformer(["platform", "status", "collection"]));
        $resource->setPaginator(new IlluminatePaginatorAdapter($arrDeployments));
        
        return (new Manager)->createData($resource)->toArray();
    }
}
