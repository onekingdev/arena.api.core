<?php

namespace App\Events\Soundblock;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Soundblock\Accounts\AccountNote;
use Illuminate\Broadcasting\InteractsWithSockets;

class AccountNoteAttach {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public AccountNote $objNote;

    public array $urls;

    /**
     * Create a new event instance.
     *
     * @param AccountNote $objNote
     * @param array $attachmentUrl
     */
    public function __construct(AccountNote $objNote, array $attachmentUrl) {
        $this->objNote = $objNote;
        $this->urls = $attachmentUrl;
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
