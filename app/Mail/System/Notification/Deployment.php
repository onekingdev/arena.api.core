<?php

namespace App\Mail\System\Notification;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class Deployment extends Mailable{
    use Queueable, SerializesModels;

    /**
     * @var Collection
     */
    private Collection $objDeployments;

    /**
     * Create a new message instance.
     *
     * @param Collection $objDeployments
     */
    public function __construct(Collection $objDeployments) {
        $this->objDeployments = $objDeployments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $frontendUrl = app_url("office", "http://localhost:8200") . "soundblock/deployments";

        return $this->view('mail.system.notification.deployment')->from("office@support.arena.com", "Arena Office")
            ->subject("Soundblock Deployment Requests")
            ->with(["link" => $frontendUrl, "deployments" => $this->objDeployments]);
    }
}
