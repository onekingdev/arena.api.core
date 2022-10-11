<?php

namespace App\Http\Controllers\Soundblock;

use App\Contracts\Soundblock\Events;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\{Request, Response};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Event extends Controller {
    /** @var Events */
    private Events $eventService;

    /**
     * Event constructor.
     * @param Events $eventService
     */
    public function __construct(Events $eventService) {
        $this->eventService = $eventService;
    }

    /**
     * @param Request $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function index(Request $objRequest) {
        $arrEvents = $this->eventService->getUserUnprocessedEvents(Auth::user(), $objRequest->input("per_page", 10));

        return $this->apiReply($arrEvents);
    }

    /**
     * @param string $event
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function processEvent(string $event) {
        $objEvent = $this->eventService->find($event);

        if (is_null($objEvent)) {
            return $this->apiReject(null, "", Response::HTTP_NOT_FOUND);
        }

        $objEvent = $this->eventService->processEvent($objEvent);

        return $this->apiReply($objEvent);
    }
}
