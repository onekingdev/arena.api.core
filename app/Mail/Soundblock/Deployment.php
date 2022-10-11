<?php

namespace App\Mail\Soundblock;

use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Repositories\Soundblock\Project as ProjectRepository;

class Deployment extends Mailable{
    use Queueable, SerializesModels;

    private array $objDeployments;
    private string $projectId;

    /**
     * Create a new message instance.
     *
     * @param string $projectId
     * @param array $arrDeployments
     */
    public function __construct(string $projectId, array $arrDeployments) {
        $this->objDeployments = $arrDeployments;
        $this->projectId = $projectId;
    }

    /**
     * Build the message.
     *
     * @param ProjectRepository $projectRepo
     * @return $this
     */
    public function build(ProjectRepository $projectRepo) {
        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));
        $this->subject("Project Deployments Update.");
        $this->withSwiftMessage(function ($message) {
            $message->app = App::where("app_name", "soundblock")->first();
        });

        $objProject = $projectRepo->find($this->projectId);
        $frontendUrl = app_url("soundblock", "http://localhost:4200") . "project/" . $this->projectId . "/deployments";

        return ($this->view('mail.soundblock.deployment')
                    ->with([
                        "link" => $frontendUrl,
                        "deployments" => $this->objDeployments,
                        "project" => $objProject->project_title
                    ])
        );
    }
}
