<?php

namespace App\Mail\Soundblock\Contract;

use Util;
use Carbon\Carbon;
use App\Models\Core\App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Soundblock\Projects\Contracts\Contract;

class Accepted extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    /** @var Project */
    private Project $project;
    /** @var App */
    private App $app;
    /** @var Contract */
    private Contract $contract;
    private bool $isOwner;
    private ?string $userName;

    /**
     * Create a new message instance.
     *
     * @param Contract $objContract
     * @param App $app
     * @param bool $isOwner
     * @param string $userName
     */
    public function __construct(Contract $objContract, App $app, bool $isOwner = true, string $userName = "") {
        $this->contract = $objContract;
        $this->project = $objContract->project;
        $this->app = $app;
        $this->isOwner = $isOwner;
        $this->userName = $userName;
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

        if ($this->isOwner) {
            $this->subject("User Accepted Contract");
        } else {
            $this->subject("Accepted Contract");
        }

        $frontendUrl .= "project/{$this->project->project_uuid}/contract";

        $projectDetails = [
            "Name"         => $this->project->project_title,
            "Type"         => $this->project->project_type,
            "Label"        => $this->project->project_label,
            "Release Date" => Carbon::parse($this->project->project_date)->format("m/d/Y"),
            "Creator"      => $this->project->stamp_created_by["name"],
        ];

        $accountDetails = [
            "Name"   => $this->project->account->account_name,
            "Status" => $this->project->account->flag_status,
            "Holder" => $this->project->account->user->name,
        ];

        return ($this->view("mail.soundblock.contract.accepted"))->with([
            "frontendUrl" => $frontendUrl,
            "project"     => $projectDetails,
            "account"     => $accountDetails,
            "isOwner"     => $this->isOwner,
            "userName"    => $this->userName,
            "artwork"     => $this->project->artwork,
        ]);
    }
}
