<?php

namespace App\Events\Soundblock;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Track;

class TrackVolumeNumber
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Track
     */
    public Track $objTrack;
    public int $newVolumeNumber;

    /**
     * Create a new event instance.
     *
     * @param Track $objTrack
     * @param int $newVolumeNumber
     */
    public function __construct(Track $objTrack, int $newVolumeNumber)
    {
        $this->objTrack = $objTrack;
        $this->newVolumeNumber = $newVolumeNumber;
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
