<?php

namespace App\Events\Soundblock;

use App\Contracts\Soundblock\Projects\Team as TeamContract;
use App\Models\Soundblock\Projects\Project;
use App\Models\Users\User;
use App\Services\Core\Auth\AuthGroup;
use App\Services\Core\Auth\AuthPermission;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateTeamPermission implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Project
     */
    private Project $objProject;
    /**
     * @var User
     */
    private User $objUser;

    /**
     * Create a new event instance.
     *
     * @param Project $objProject
     * @param User $objUser
     */
    public function __construct(Project $objProject, User $objUser) {
        $this->objProject = $objProject;
        $this->objUser = $objUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return (new PrivateChannel("channel.app.soundblock.project.{$this->objProject->project_uuid}.team.{$this->objUser->user_uuid}"));
    }

    public function broadcastAs() {
        return ("Soundblock.Project.{$this->objProject->project_uuid}.Team.{$this->objUser->user_uuid}");
    }

    public function broadcastWith() {
        /** @var AuthGroup $objAuthGroupService */
        $objAuthGroupService = resolve(AuthGroup::class);
        $projectGroup = $objAuthGroupService->findByProject($this->objProject);
        $accountGroup = $objAuthGroupService->findByAccount($this->objProject->account);

        /** @var AuthPermission $objAuthPermissionService */
        $objAuthPermissionService = resolve(AuthPermission::class);
        $arrProjectPermission = $objAuthPermissionService->findAllUserPermissionsByGroup($projectGroup, $this->objUser)->toArray();
        $arrAccountPermission = $objAuthPermissionService->findAllUserPermissionsByGroup($accountGroup, $this->objUser)->toArray();

        return (array_merge($arrAccountPermission, $arrProjectPermission));
    }
}
