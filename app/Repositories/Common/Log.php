<?php

namespace App\Repositories\Common;

use Carbon\Carbon;
use Util;
use App\Models\Common\{Log as LogModel, LogError};
use App\Repositories\Common\LogError as LogErrorRepository;
use App\Contracts\Exceptions\Exception;

class Log {

    protected LogModel $model;
    /**
     * @var LogErrorRepository
     */
    private LogErrorRepository $logErrorRepository;

    /**
     * LogRepository constructor.
     * @param LogModel $logError
     * @param LogErrorRepository $logErrorRepository
     */
    public function __construct(LogModel $logError, LogErrorRepository $logErrorRepository) {
        $this->model = $logError;
        $this->logErrorRepository = $logErrorRepository;
    }

    /**
     * @param Carbon $period
     * @param Exception $exceptionContract
     * @return bool
     */
    public function canSkipLog(Carbon $period, Exception $exceptionContract): bool {
        return $this->logErrorRepository->checkExceptionExistInPeriod($period, $exceptionContract);
    }

    /**
     * @param Exception $exception
     * @return LogModel
     * @throws \Exception
     */
    public function createLog(Exception $exception): LogModel {
        $arrExDetails = $exception->getDetails();

        /** @var LogModel $log */
        $log = $this->model->create(["log_uuid" => Util::uuid()]);
        /** @var LogError $logError */
        $logError = $log->logError()->create([
            "row_uuid"          => Util::uuid(),
            "log_uuid"          => $log->log_uuid,
            "log_command"       => $exception->isCommand() ? $arrExDetails["command"] : null,
            "log_url"           => $exception->isHttp() ? $arrExDetails["endpoint"] : null,
            "log_method"        => $exception->isHttp() ? $arrExDetails["method"] : null,
            "log_request"       => $exception->isHttp() ? $arrExDetails["request"] : null,
            "log_instance"      => $exception->getInstanceId(),
            "exception_class"   => get_class($exception),
            "exception_message" => $arrExDetails["message"],
            "exception_trace"   => $arrExDetails["trace"],
            "exception_code"    => $arrExDetails["code"],
        ]);

        $objUser = $exception->getUser();

        if (!is_null($objUser)) {
            $logError->user()->associate($objUser);
            $logError->user_uuid = $objUser->user_uuid;
            $logError->save();
        }

        return $log;
    }
}
