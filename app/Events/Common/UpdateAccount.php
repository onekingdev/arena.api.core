<?php

namespace App\Events\Common;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Soundblock\Accounts\Account;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdateAccount {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Account $objAccount;

    public Account $objNewAccount;

    /**
     * Create a new event instance.
     *
     * @param Account $objAccount
     * @param Account $objNewAccount
     */
    public function __construct(Account $objAccount, Account $objNewAccount) {
        $this->objAccount = $objAccount;
        $this->objNewAccount = $objNewAccount;
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
