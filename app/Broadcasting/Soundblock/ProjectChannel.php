<?php

namespace App\Broadcasting\Soundblock;

use App\Models\Users\User;
use App\Services\Office\Contact;
use App\Services\Soundblock\Contracts\Service;
use App\Services\Soundblock\Project;

class ProjectChannel {
    /**
     * @var Project
     */
    private Project $project;

    /**
     * ContractChannel constructor.
     * @param Project $project
     */
    public function __construct(Project $project) {
        $this->project = $project;
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param User $user
     * @param string $project
     * @return bool
     */
    public function join(User $user, string $project) {
        $objProject = $this->project->find($project, false);

        if (is_null($objProject)) {
            return false;
        }

        return $this->project->checkUserInProject($objProject->project_uuid, $user);
    }
}
