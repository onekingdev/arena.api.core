<?php

namespace App\Repositories\Common;

use Carbon\Carbon;
use App\Models\Common\LogError as LogErrorModel;
use App\Contracts\Exceptions\Exception;

class LogError {
    /**
     * @var LogErrorModel
     */
    private LogErrorModel $model;

    public function __construct(LogErrorModel $logError) {
        $this->model = $logError;
    }

    /**
     * @param Carbon $period
     * @param Exception $exceptionContract
     * @return bool
     */
    public function checkExceptionExistInPeriod(Carbon $period, Exception $exceptionContract): bool {
        $exDetails = $exceptionContract->getDetails();

        return $this->model->where("stamp_created_at", ">", $period)
                           ->where("exception_class", get_class($exceptionContract))
                           ->where("exception_message", $exDetails["message"])->exists();
    }
}
