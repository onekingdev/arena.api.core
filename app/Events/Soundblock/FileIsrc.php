<?php

namespace App\Events\Soundblock;

use App\Models\Soundblock\Files\File;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FileIsrc implements ShouldBroadcast{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var File
     */
    private File $file;
    /**
     * @var Project
     */
    private Project $project;

    /**
     * Create a new event instance.
     * @param File $file
     * @param Project $project
     */
    public function __construct(File $file, Project $project) {
        $this->file = $file;
        $this->project = $project;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.soundblock.project.{$this->project->project_uuid}"));
    }

    public function broadcastAs() {
        return ("Soundblock.Project.{$this->project->project_uuid}.File");
    }

    public function broadcastWith() {
        return ($this->file->load("music")->toArray());
    }
}
