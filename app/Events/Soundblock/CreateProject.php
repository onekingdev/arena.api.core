<?php

namespace App\Events\Soundblock;

use App\Models\Users\User;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;

class CreateProject {
    use SerializesModels;

    /**
     * @var Project $objProject
     */
    public Project $objProject;
    public array $arrUsers;


    /**
     * Create a new event instance.
     *
     * @param Project $objProject
     * @param array $arrUsers
     */
    public function __construct(Project $objProject, array $arrUsers) {
        $this->objProject = $objProject;
        $this->arrUsers = $arrUsers;
    }
}
