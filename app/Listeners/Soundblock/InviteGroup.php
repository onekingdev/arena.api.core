<?php

namespace App\Listeners\Soundblock;

use Util;
use Client;
use App\Models\Soundblock\Projects\Project;
use App\Events\Soundblock\InviteGroup as InviteGroupEvent;
use App\Services\{Core\Auth\AuthGroup, Soundblock\Team};

class InviteGroup {
    protected AuthGroup $authGroupService;

    protected Team $teamService;

    /**
     * Create the event listener.
     *
     * @param AuthGroup $authGroupService
     * @param Team $teamService
     */
    public function __construct(AuthGroup $authGroupService, Team $teamService) {
        $this->authGroupService = $authGroupService;
        $this->teamService = $teamService;
    }

    /**
     * Handle the event.
     *
     * @param InviteGroupEvent $event
     * @return void
     */
    public function handle(InviteGroupEvent $event) {
        $arrEmail = $event->arrEmail;
        /** @var Project */
        $objProject = $event->objProject;
        $objAuth = $event->objAuth ?? Client::auth();
        $objApp = $event->objApp ?? Client::app();
        $arrUsers = collect();

        foreach ($arrEmail as $email) {
            $arrUsers->push($email->user);
        }

        $groupName = Util::makeGroupName($objAuth, "project", $objProject);
        $objAuthGroup = $this->authGroupService->findByName($groupName);
        $objAuthGroup = $this->authGroupService->addUsersToGroup($arrUsers, $objAuthGroup, $objApp);
    }
}
