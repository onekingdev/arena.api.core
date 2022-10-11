<?php

namespace App\Contracts\Soundblock;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Users\User, Soundblock\Event};

interface Events {
    public function find(string $eventUuid);
    public function create(User $objUser, string $strEventMemo, ?Model $objEventable = null): Event;
    public function processEvent(Event $objEvent): Event;
    public function getUserUnprocessedEvents(User $objUser, int $perPage = 10);
}