<?php

namespace App\Listeners\Soundblock;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Soundblock\DeploymentHistory as DeploymentHistoryEvent;
use App\Repositories\Soundblock\DeploymentHistory as DeploymentHistoryRepository;
use Util;

class DeploymentHistory
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
     * @param  DeploymentHistoryEvent  $event
     * @return void
     */
    public function handle(DeploymentHistoryEvent $event)
    {
        $objDeploymentHistoryRepo = resolve(DeploymentHistoryRepository::class);
        $objDeploymentHistoryRepo->create([
            "row_uuid" => Util::uuid(),
            "deployment_id" => $event->objDeployment->deployment_id,
            "deployment_uuid" => $event->objDeployment->deployment_uuid,
            "collection_id" => $event->objDeployment->collection_id,
            "collection_uuid" => $event->objDeployment->collection_uuid,
            "platform_id" => $event->objDeployment->platform_id,
            "platform_uuid" => $event->objDeployment->platform_uuid,
            "flag_action" => $event->status
        ]);
    }
}
