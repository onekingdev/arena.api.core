<?php

namespace App\Listeners\Office;

use Log;
use App\Services\Soundblock\Deployment;

class UpdateDeployment {
    protected Deployment $deploymentService;

    /**
     * Create the event listener.
     *
     * @param Deployment $deploymentService
     */
    public function __construct(Deployment $deploymentService) {
        $this->deploymentService = $deploymentService;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event) {
        $objDeployment = $event->objDeployment;

        if ($objDeployment->status) {
            $objStatus = $objDeployment->status;
        } else {
            Log::info("Create - status", [$objDeployment->deployment_uuid]);
            $objStatus = $this->deploymentService->createDeploymentStatus($objDeployment);
        }

        $this->deploymentService->updateDeploymentStatus($objStatus, $objDeployment);
    }
}
