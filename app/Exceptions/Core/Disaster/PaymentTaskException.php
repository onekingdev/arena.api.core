<?php

namespace App\Exceptions\Core\Disaster;

use Throwable;
use App\Contracts\Exceptions\Exception;

class PaymentTaskException extends DisasterExceptions implements Exception {
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
