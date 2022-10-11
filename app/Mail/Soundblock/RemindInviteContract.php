<?php

namespace App\Mail\Soundblock;

use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Soundblock\Invites;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemindInviteContract extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Project
     */
    private Project $project;
    /**
     * @var App
     */
    private App $app;
    /**
     * @var array
     */
    private array $params;

    /**
     * Create a new message instance.
     *
     * @param Project $project
     * @param App $app
     * @param array $params
     */
    public function __construct(Project $project, App $app, array $params = []) {
        $this->project = $project;
        $this->app = $app;
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $host = app_url("soundblock", "http://localhost:8200");
        $frontendUrl = $host . "project/" . $this->project->project_uuid;

        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));

        $projectDetails = [
            "Type" => $this->project->project_type,
            "Genre" => "Rock",
            "Release Date" => $this->project->project_date,
            "Creator" => $this->project->stamp_created_by["name"]
        ];

        $accountDetails = [
            "Name" => $this->project->account->account_name,
            "Status" => $this->project->account->flag_status,
            "Holder" => $this->project->account->user->name
        ];

        return ($this->view("mail.soundblock.remind")->with([
            "name" => $this->project->project_title,
            "frontendUrl" => $frontendUrl,
            "params" => $this->params,
            "project" => $projectDetails,
            "account" => $accountDetails
        ]));
    }
}
