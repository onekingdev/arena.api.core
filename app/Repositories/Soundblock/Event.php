<?php

namespace App\Repositories\Soundblock;

use Util;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Users\User, Soundblock\Event as EventModel};

class Event extends BaseRepository {
    public function __construct(EventModel $objEvent) {
        $this->model = $objEvent;
    }

    public function getUnprocessedEvents(User $objUser, int $perPage = 10) {
        return $objUser->soundblockEvents()->unprocessed()->paginate($perPage);
    }

    public function createEvent(User $objUser, string $strMemo, ?Model $objEventable = null): EventModel {
        return $objUser->soundblockEvents()->create([
            "event_uuid" => Util::uuid(),
            "user_uuid"  => $objUser->user_uuid,
            "event_memo" => $strMemo,
            "eventable_type" => is_null($objEventable) ? $objEventable : get_class($objEventable),
            "eventable_id" => is_null($objEventable) ? $objEventable : $objEventable->getKey(),
        ]);
    }

    public function process(EventModel $objEvent): EventModel {
        $objEvent->flag_processed = true;
        $objEvent->save();

        return $objEvent;
    }
}
