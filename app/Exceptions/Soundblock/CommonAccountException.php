<?php

namespace App\Exceptions\Soundblock;

use Exception;

class CommonAccountException extends Exception {
    protected $userUUID;

    /**
     * CommonAccountException constructor.
     * @param $userUUID
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($userUUID, $message = "", $code = 0, Exception $previous = null) {
        $this->userUUID = $userUUID;
        $message = "This user has his own account already.";
        $code = 400;
        parent::__construct($message, $code, $previous);
    }

    public static function cantCreateAccount($userUUID, Exception $previous = null) {
        return (new static($userUUID, sprintf("This user %s has his/her own account already.", $userUUID), 400, $previous));
    }

    public function getUserUUID() {
        return ($this->userUUID);
    }

    public function report() {
        \Log::debug("Account Security Exception");
    }
}
