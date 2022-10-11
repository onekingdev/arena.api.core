<?php

namespace App\Contracts\Exceptions;

interface Disaster {
    public function handleDisaster(Exception $exception);
}
