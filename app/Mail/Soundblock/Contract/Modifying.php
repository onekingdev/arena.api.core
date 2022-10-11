<?php

namespace App\Mail\Soundblock\Contract;

use Util;
use Carbon\Carbon;
use App\Models\Core\App;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Soundblock\Projects\Contracts\Contract;

class Modifying extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    /** @var Project */
    private Project $project;
    /** @var App */
    private App $app;
    /** @var Contract */
    private Contract $contract;
    /** @var User */
    private User $objUser;


    /**
     * Create a new message instance.
     *
     * @param Contract $objContract
     * @param App $app
     * @param User $objUser
     */
    public function __construct(Contract $objContract, App $app, User $objUser) {
        $this->contract = $objContract;
        $this->project = $objContract->project;
        $this->app = $app;
        $this->objUser = $objUser;
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
        $this->subject("Contract Modifications Proposed");

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

        $objContractUsers = $this->contract->users()
                                           ->where("soundblock_projects_contracts_users.contract_version", $this->contract->contract_version)
                                           ->get();
        $arrContractUsers = $objContractUsers->pluck("name");

        return ($this->view("mail.soundblock.contract.modifying"))->with([
            "frontendUrl"   => $frontendUrl,
            "project"       => $projectDetails,
            "account"       => $accountDetails,
            "userName"      => $this->objUser->name,
            "artwork"       => $this->project->artwork,
            "contractUsers" => $arrContractUsers->toArray(),
        ]);
    }
}
