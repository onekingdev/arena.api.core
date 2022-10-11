<?php

namespace App\Facades\Soundblock;


use Illuminate\Support\Facades\Facade;

class Events extends Facade {
    protected static function getFacadeAccessor() {
        return "arena-soundblock-events";
    }
}