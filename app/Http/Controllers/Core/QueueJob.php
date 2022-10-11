<?php

namespace App\Http\Controllers\Core;

use Exception;
use App\Services\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Job\{UpdateJob};
use App\Services\Core\Auth\{AuthGroup, AuthPermission};
use App\Services\Common\QueueJob as QueueJobService;

/**
 * @group Core
 *
 */
class QueueJob extends Controller {
    /** @var Auth */
    protected Auth $authService;
    /** @var AuthGroup */
    protected AuthGroup $authGroupService;
    /** @var AuthPermission */
    protected AuthPermission $authPermService;

    /**
     * @param Auth $authService
     * @param AuthGroup $authGroupService
     * @param AuthPermission $authPermService
     * @return void
     */
    public function __construct(Auth $authService, AuthGroup $authGroupService, AuthPermission $authPermService) {
        $this->authService = $authService;
        $this->authGroupService = $authGroupService;
        $this->authPermService = $authPermService;
    }

    public function index(QueueJobService $qjService) {

    }

    /**
     * @param string $job
     * @param QueueJobService $qjService
     * @return \Illuminate\Http\Response|object
     * @throws Exception
     */
    public function show(string $job, QueueJobService $qjService) {
        try {
            $arrStatus = $qjService->getStatus($job);
            return ($this->apiReply($arrStatus));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param QueueJobService $qjService
     * @return mixed \Dingo\Api\Http\Response
     * @throws Exception
     */
    public function status(QueueJobService $qjService) {
        try {
            $arrStatus = $qjService->getJobsStatus();
            return ($this->apiReply($arrStatus));
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param UpdateJob $objRequest
     * @param QueueJobService $qjService
     * @return \Illuminate\Http\Response|object
     * @throws Exception
     */
    public function update(UpdateJob $objRequest, QueueJobService $qjService) {
        try {
            $objQueueJob = $qjService->find($objRequest->job);
            $objQueueJob = $qjService->update($objQueueJob, $objRequest->all());

            return ($this->apiReply($objQueueJob));
        } catch (Exception $e) {
            throw $e;
        }
    }
}
