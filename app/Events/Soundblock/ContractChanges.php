<?php

namespace App\Events\Soundblock;

use App\Services\Soundblock\Project;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Soundblock\Projects\Contracts\Contract;
use App\Contracts\Soundblock\Contracts\SmartContracts;
use App\Contracts\Soundblock\Projects\Team as TeamContract;

class ContractChanges implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Contract
     */
    private Contract $contract;

    /**
     * Create a new event instance.
     *
     * @param Contract $contract
     */
    public function __construct(Contract $contract) {
        $this->contract = $contract;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.soundblock.project.{$this->contract->project_uuid}.contract"));
    }

    public function broadcastAs() {
        return ("Soundblock.Project.{$this->contract->project_uuid}.Contract");
    }

    public function broadcastWith() {
        /** @var SmartContracts $contractService*/
        $contractService = resolve(SmartContracts::class);

        return ($contractService->getContractInfo($this->contract)->toArray());
    }
}
