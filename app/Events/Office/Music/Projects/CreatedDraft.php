<?php

namespace App\Events\Office\Music\Projects;

use App\Models\Music\Project\ProjectDraftVersion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatedDraft implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ProjectDraftVersion
     */
    private ProjectDraftVersion $draftVersion;

    /**
     * Create a new event instance.
     *
     * @param ProjectDraftVersion $draftVersion
     */
    public function __construct(ProjectDraftVersion $draftVersion) {
        $this->draftVersion = $draftVersion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.office.music.draft.{$this->draftVersion->draft_uuid}"));
    }

    public function broadcastAs() {
        return ("Office.Music.Draft.{$this->draftVersion->draft_uuid}");
    }

    public function broadcastWith() {
        return ($this->draftVersion->load("draft")->toArray());
    }
}
