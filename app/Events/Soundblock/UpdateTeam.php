<?php

namespace App\Events\Soundblock;

use App\Contracts\Soundblock\Contracts\SmartContracts;
use App\Contracts\Soundblock\Projects\Team as TeamContract;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Projects\Team;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateTeam implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Project
     */
    public Project $objProject;

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
        return (new PrivateChannel("channel.app.soundblock.project.{$this->objProject->project_uuid}.team"));
    }

    public function broadcastAs() {
        return ("Soundblock.Project.{$this->objProject->project_uuid}.Team");
    }

    public function broadcastWith() {
        /** @var TeamContract $objTeamService*/
        $objTeamService = resolve(TeamContract::class);

        return ($objTeamService->getUsers($this->objProject)->toArray());
    }
}
