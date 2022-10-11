<?php

namespace App\Events\Soundblock;

use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CreateContract {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Project $objProject;

    public Collection $arrContracts;

    /**
     * Create a new event instance.
     *
     * @param Project $objProject
     * @param Collection $arrContracts
     */
    public function __construct(Project $objProject, Collection $arrContracts) {
        $this->objProject = $objProject;
        $this->arrContracts = $arrContracts;
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
