<?php

namespace App\Services\Soundblock;

use App\Repositories\Soundblock\Event;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Soundblock\Events as EventsContract;
use App\Models\{Users\User, Soundblock\Event as EventModel};

class Events implements EventsContract {
    /** @var Event */
    private Event $objEventRepository;

    /**
     * Events constructor.
     * @param Event $objEventRepository
     */
    public function __construct(Event $objEventRepository) {
        $this->objEventRepository = $objEventRepository;
    }

    public function create(User $objUser, string $strEventMemo, ?Model $objEventable = null): EventModel {
        return ($this->objEventRepository->createEvent($objUser, $strEventMemo, $objEventable));
    }

    public function processEvent(EventModel $objEvent): EventModel {
        return ($this->objEventRepository->process($objEvent));
    }

    public function find(string $eventUuid): ?EventModel {
        return ($this->objEventRepository->find($eventUuid));
    }

    public function getUserUnprocessedEvents(User $objUser, int $perPage = 10) {
        return ($this->objEventRepository->getUnprocessedEvents($objUser, $perPage));
    }
}
