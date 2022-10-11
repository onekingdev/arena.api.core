<?php

namespace App\Events\Soundblock\Ledger;

use App\Models\Soundblock\Projects\Project;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectLedger implements ShouldBroadcastNow {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $strEntity;
    private string $strUuid;
    /**
     * @var Project
     */
    private Project $objProject;
    private string $ledgerUuid;

    /**
     * Create a new event instance.
     *
     * @param Project $objProject
     * @param string $ledgerUuid
     * @param string $strEntity
     * @param string $strUuid
     */
    public function __construct(Project $objProject, string $ledgerUuid, string $strEntity, string $strUuid) {
        $this->strEntity = $strEntity;
        $this->strUuid = $strUuid;
        $this->objProject = $objProject;
        $this->ledgerUuid = $ledgerUuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.soundblock.project.{$this->objProject->project_uuid}.ledger"));
    }

    public function broadcastAs() {
        return ("Soundblock.Project.{$this->objProject->project_uuid}.Ledger");
    }

    public function broadcastWith() {
        return ([
            "entity"      => $this->strEntity,
            "entity_uuid" => $this->strUuid,
            "ledger_uuid" => $this->ledgerUuid,
        ]);
    }
}
