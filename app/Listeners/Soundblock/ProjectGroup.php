<?php

namespace App\Listeners\Soundblock;

use Client;
use Constant;
use App\Models\Users\User;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Soundblock\Projects\Project;
use App\Events\Soundblock\ProjectGroup as ProjectGroupEvent;
use App\Services\Core\Auth\{AuthGroup as AuthGroupService, AuthPermission};

class ProjectGroup {
    /**
     * @var AuthGroupService $groupService
     */
    private AuthGroupService $groupService;
    /**
     * @var AuthPermission
     */
    private AuthPermission $permissionService;

    /**
     * Create the event listener.
     * @param AuthGroupService $groupService
     * @param AuthPermission $permissionService
     *
     * @return void
     */
    public function __construct(AuthGroupService $groupService, AuthPermission $permissionService) {
        $this->groupService = $groupService;
        $this->permissionService = $permissionService;
    }

    /**
     * Handle the event.
     *
     * @param ProjectGroupEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(ProjectGroupEvent $event) {
        /** @var User */
        $user = $event->user;
        /** @var Project */
        $project = $event->project;
        /** @var AuthGroup */
        $group = $this->groupService->findByProject($project);
        if ($this->groupService->checkIfUserExists($user, $group) != Constant::EXIST) {
            // Add a user to a group.
            $this->groupService->addUserToGroup($user, $group, Client::app());
            // Attach service level permissions to the user by default.
            $this->permissionService->attachUserPermissions(Constant::account_level_permissions(), $user, $group, 0);
        }
    }
}
