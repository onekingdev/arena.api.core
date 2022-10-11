<?php

namespace App\Mail\Soundblock;

use Util;
use App\Models\{
    Core\App,
    Soundblock\Invites,
    Soundblock\Projects\Project
};
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invite extends Mailable {
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
     * @var Invites|null
     */
    private ?Invites $invite;
    /**
     * @var array|null
     */
    private ?array $params;
    private bool $flagAccept;
    private bool $flagContract;

    /**
     * Create a new message instance.
     *
     * @param Project $project
     * @param App $app
     * @param Invites|null $invite
     * @param array|null $params
     * @param bool $flagAccept
     * @param bool $flagContract
     */
    public function __construct(Project $project, App $app, ?Invites $invite = null, ?array $params = [], bool $flagAccept = true, bool $flagContract = false) {
        $this->project = $project;
        $this->app = $app;
        $this->invite = $invite;
        $this->params = $params;
        $this->flagAccept = $flagAccept;
        $this->flagContract = $flagContract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $frontendUrl = app_url("soundblock", "http://localhost:4200");

        $this->withSwiftMessage(function ($message) {
            $message->app = $this->app;
        });

        $this->from(config("constant.email.soundblock.address"), config("constant.email.soundblock.name"));

        if (is_null($this->invite)) {
            $frontendUrl .= "project/{$this->project->project_uuid}/contract";
        } else {
            $frontendUrl .= "invite/{$this->invite->invite_hash}";
        }

        $projectDetails = [
            "Type"         => $this->project->project_type,
            "Name"         => $this->project->project_title,
            "Release Date" => $this->project->project_date,
            "Creator"      => $this->project->stamp_created_by["name"],
        ];

        $accountDetails = [
            "Name"   => $this->project->account->account_name,
            "Status" => $this->project->account->flag_status,
            "Holder" => $this->project->account->user->name,
        ];

        return ($this->view("mail.soundblock.invite"))->subject("Project Invitation")->with([
            "frontendUrl"  => $frontendUrl,
            "params"       => $this->params,
            "project"      => $projectDetails,
            "account"      => $accountDetails,
            "artwork"      => $this->project->artwork,
            "flagAccept"    => $this->flagAccept,
            "flagContract"  => $this->flagContract,
        ]);
    }
}
