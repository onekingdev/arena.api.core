<?php


namespace App\Facades\Exceptions;

use App\Contracts\Exceptions\Exception;
use Illuminate\Support\Facades\Facade;

/**
 * @method static handleDisaster(Exception $exception)
 */
class Disaster extends Facade {
    protected static function getFacadeAccessor() {
        return 'disaster';
    }
}
