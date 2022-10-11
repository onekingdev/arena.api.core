<?php

namespace App\Services\Exceptions;

use App\Contracts\Core\Slack;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Common\{Log};
use Illuminate\Database\QueryException;
use App\Repositories\Common\Log as LogRepository;
use App\Contracts\Exceptions\{Disaster as DisasterContract, Exception};

class Disaster implements DisasterContract {
    /**
     * @var Client
     */
    private Client $http;
    /**
     * @var LogRepository
     */
    private LogRepository $logRepository;
    /**
     * @var Slack
     */
    private Slack $slack;

    /**
     * DisasterService constructor.
     * @param LogRepository $logRepository
     * @param Slack $slack
     */
    public function __construct(LogRepository $logRepository, Slack $slack) {
        $this->http = new Client();
        $this->logRepository = $logRepository;
        $this->slack = $slack;
    }

    public function handleDisaster(Exception $exception) {
        $timeLastException = Carbon::now()->subMinutes(15);

        try{
            if($this->logRepository->canSkipLog($timeLastException, $exception)) {
                return;
            }

            $log = $this->logRepository->createLog($exception);
            $logError = $log->logError;

            if (config("app.env") != "local") {
                if(!empty($this->slackUrl)) {
                    $this->slack->exceptionNotification($logError);
                }
            }

        } catch(QueryException $exception){
            if($exception->getCode() == "42S02" || $exception->getCode() == "HY000") {
                return;
            }

            throw new QueryException($exception->getSql(), $exception->getBindings(), $exception);
        }
    }
}
