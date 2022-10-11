<?php

namespace App\Providers;

use App\Listeners\{Pagination,
    Common\CreateAccount,
    Common\JobExceptionOccured,
    Common\MessageSent,
    Common\PrivateNotification,
    Accounting\CreateTransaction,
    Office\UpdateDeployment,
    Office\Support\TicketAttach,
    Soundblock\CreateContract,
    Soundblock\DeploymentHistory,
    Soundblock\Deployment,
    Soundblock\InviteGroup,
    Soundblock\CreateProject,
    Soundblock\InviteTeam,
    Soundblock\OnHistory,
    Soundblock\ProjectGroup,
    Soundblock\ProjectNoteAttach,
    Soundblock\AccountNoteAttach,
    User\DeleteEmail,
    User\UserNoteAttach,
    User\DeleteUserNote,
    Soundblock\TrackVolumeNumber
};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventService extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        "Dingo\Api\Event\ResponseWasMorphed" => [
            Pagination::class
        ],

        "App\Events\Soundblock\CreateProject" => [
            CreateProject::class
        ],
        "App\Events\Common\CreateAccount" => [
            CreateAccount::class
        ],
        "App\Events\Soundblock\OnHistory" => [
            OnHistory::class
        ],
        "App\Events\Common\PrivateNotification" => [
            PrivateNotification::class
        ],
        "App\Events\Soundblock\CreateContract" => [
            CreateContract::class
        ],
        "App\Events\Soundblock\InviteGroup" => [
            InviteGroup::class
        ],
        "App\Events\Soundblock\InviteTeam" => [
            InviteTeam::class
        ],
        "App\Events\Office\UpdateDeployment" => [
            UpdateDeployment::class
        ],
        "App\Events\Soundblock\ProjectNoteAttach" => [
            ProjectNoteAttach::class
        ],
        "App\Events\Soundblock\AccountNoteAttach" => [
            AccountNoteAttach::class
        ],
        "App\Events\User\UserNoteAttach" => [
            UserNoteAttach::class
        ],
        "App\Events\Office\Support\TicketAttach" => [
            TicketAttach::class
        ],
        "App\Events\User\DeleteUserNote" => [
            DeleteUserNote::class
        ],
        "App\Events\User\DeleteEmail" => [
            DeleteEmail::class
        ],
        "App\Events\Accounting\CreateTransaction" => [
            CreateTransaction::class
        ],
        "App\Events\Soundblock\ProjectGroup" => [
            ProjectGroup::class
        ],
        "App\Events\Soundblock\DeploymentHistory" => [
            DeploymentHistory::class
        ],
        "App\Events\Soundblock\Deployment" => [
            Deployment::class
        ],
        "App\Events\Soundblock\TrackVolumeNumber" => [
            TrackVolumeNumber::class
        ],
        "Illuminate\Queue\Events\JobExceptionOccurred" => [
            JobExceptionOccured::class
        ],
        "Illuminate\Queue\Events\JobFailed" => [
            JobExceptionOccured::class
        ],
        "Illuminate\Mail\Events\MessageSent" => [
            MessageSent::class
        ]
    ];

    protected $subscribe = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
