<?php

namespace App\Contracts\Exceptions;

use App\Models\Users\User;

interface Exception extends \Throwable {
    public function getDetails() : array;
    public function getUser() : ?User;
    public function getInstanceId(): ?string;

    public function isHttp() : bool;
    public function isCommand() : bool;
}
