<?php

namespace App\Events\Soundblock\Ledger;

use App\Models\Soundblock\Accounts\Account;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServiceLedger implements ShouldBroadcastNow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Account
     */
    private Account $objAccount;

    /**
     * Create a new event instance.
     *
     * @param Account $objAccount
     */
    public function __construct(Account $objAccount) {
        $this->objAccount = $objAccount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.soundblock.account.{$this->objAccount->account_uuid}.ledger"));
    }

    public function broadcastAs() {
        return ("Soundblock.Account.{$this->objAccount->account_uuid}.Ledger");
    }

    public function broadcastWith() {
        return ([
            "entity"      => "account",
            "entity_uuid" => $this->objAccount->account_uuid,
            "ledger_uuid" => $this->objAccount->ledger_uuid,
        ]);
    }
}
