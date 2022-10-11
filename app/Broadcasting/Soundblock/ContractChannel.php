<?php

namespace App\Broadcasting\Soundblock;

use App\Models\Users\User;
use App\Services\Office\Contact;
use App\Services\Soundblock\Contracts\Service;
use App\Services\Soundblock\Project;

class ContractChannel {
    /**
     * @var Project
     */
    private Project $project;
    /**
     * @var Service
     */
    private Service $contract;

    /**
     * ContractChannel constructor.
     * @param Project $project
     * @param Service $contract
     */
    public function __construct(Project $project, Service $contract) {
        $this->project = $project;
        $this->contract = $contract;
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param string $project
     * @return bool
     * @throws \Exception
     */
    public function join(User $user, string $project) {
        $objProject = $this->project->find($project, false);

        if (is_null($objProject)) {
            return false;
        }

        return (
            $objProject->team->users()->where("soundblock_projects_teams_users.user_uuid", $user->user_uuid)->exists()
        );
    }
}
