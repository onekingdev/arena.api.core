<?php

namespace App\Listeners\Soundblock;

use Mail;
use App\Mail\Soundblock\Deployment as DeploymentMail;
use App\Events\Soundblock\Deployment as CreateDeploymentEvent;

class Deployment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateDeploymentEvent  $event
     * @return void
     */
    public function handle(CreateDeploymentEvent $event)
    {
        $event->objDeployment;

        $objUsers = $event->objDeployment->project->team->users;

        foreach ($objUsers as $objUser) {
            Mail::to($objUser->primary_email->user_auth_email)->send(new DeploymentMail($event->objDeployment));
        }

        $event->objDeployment->update([
            "flag_notify_user" => true
        ]);
    }
}
