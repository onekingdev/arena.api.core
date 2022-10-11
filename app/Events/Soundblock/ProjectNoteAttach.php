<?php

namespace App\Events\Soundblock;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Soundblock\Projects\ProjectNote;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProjectNoteAttach {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ProjectNote $objNote;

    public array $urls;

    /**
     * Create a new event instance.
     *
     * @param ProjectNote $objNote
     * @param array $urls
     */
    public function __construct(ProjectNote $objNote, array $urls) {
        $this->objNote = $objNote;
        $this->urls = $urls;
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
