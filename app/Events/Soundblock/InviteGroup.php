<?php

namespace App\Events\Soundblock;

use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use App\Models\Soundblock\Projects\Project;
use Illuminate\Broadcasting\PrivateChannel;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class InviteGroup {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Collection
     */
    public Collection $arrEmail;
    /**
     * @var Project
     */
    public Project $objProject;
    public $objAuth;
    public $objApp;

    /**
     * Create a new event instance.
     * @param Collection|UserContactEmail|array $emails
     *
     * @param Project $objProject
     * @param null $objAuth
     * @param null $objApp
     * @throws \Exception
     */
    public function __construct($emails, Project $objProject, $objAuth = null, $objApp = null) {
        if ($emails instanceof Collection) {
            $this->arrEmail = $emails;
        } else if ($emails instanceof UserContactEmail) {
            $this->arrEmail = collect()->push($emails);
        } else {
            throw new \Exception("emails is invalid parameter.", 417);
        }

        $this->objProject = $objProject;
        $this->objAuth = $objAuth;
        $this->objApp = $objApp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
