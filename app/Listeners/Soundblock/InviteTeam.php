<?php

namespace App\Listeners\Soundblock;

use Mail;
use Util;
use Client;
use App\Models\Users\User;
use App\Mail\Soundblock\Invite;
use App\Services\Soundblock\Team;
use App\Models\Soundblock\Invites;

class InviteTeam {
    protected Team $teamService;

    /**
     * Create the event listener.
     *
     * @param Team $teamService
     */
    public function __construct(Team $teamService) {
        $this->teamService = $teamService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\Soundblock\InviteTeam $event
     * @return void
     * @throws \Exception
     */
    public function handle($event) {
        $arrInfo = $event->arrInfo;
        $team = $event->team;

        $this->teamService->addMembers($team, $arrInfo);
        foreach ($arrInfo as $info) {
            /** @var User */
            $user = $info["email"]->user;
            /** @var Invites */
            $invite = $team->invite()->create([
                "invite_uuid"  => Util::uuid(),
                "invite_name"  => $info["email"]->user->name,
                "invite_email" => $info["email"]->user_auth_email,
                "invite_role"  => $info["user_role"],
            ]);
            // Send mail
            Mail::to($user->recpient())->send(new Invite($team->project, Client::app(), $invite, [], true));
        }

    }
}
