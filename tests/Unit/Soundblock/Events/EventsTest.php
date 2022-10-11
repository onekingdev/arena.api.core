<?php

namespace Tests\Unit\Soundblock\Events;

use Tests\TestCase;
use App\Models\Users\User;
use App\Contracts\Soundblock\Events;
use App\Facades\Soundblock\Events as EventFacade;
use App\Services\Soundblock\Events as EventsService;
use App\Models\Soundblock\{Event, Accounts\Account, Projects\Project};

class EventsTest extends TestCase {
    private EventsService $eventService;
    private User $user;
    private Project $project;

    public function setUp(): void {
        parent::setUp();

        $this->eventService = resolve(Events::class);
        $this->user = User::factory()->create();

        $service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $this->project = $service->projects()->create(Project::factory()->make([
            "service_uuid" => $service->service_uuid,
        ])->setAppends([])->toArray());
    }

    public function testCreatingEvent() {
        $objEvent = $this->eventService->create($this->user, "Test Memo", $this->project);
        $this->assertInstanceOf(Event::class, $objEvent);

        $this->assertDatabaseHas("soundblock_events", [
            "event_memo"     => "Test Memo",
            "eventable_type" => Project::class,
            "eventable_id"   => $this->project->project_id,
            "user_id"        => $this->user->user_id,
            "user_uuid"      => $this->user->user_uuid,
            "flag_processed" => false,
        ]);
    }

    public function testCreatingEventByFacade() {
        $objEvent = EventFacade::create($this->user, "Test Memo", $this->project);
        $this->assertInstanceOf(Event::class, $objEvent);

        $this->assertDatabaseHas("soundblock_events", [
            "event_memo"     => "Test Memo",
            "eventable_type" => Project::class,
            "eventable_id"   => $this->project->project_id,
            "user_id"        => $this->user->user_id,
            "user_uuid"      => $this->user->user_uuid,
            "flag_processed" => false,
        ]);
    }

    public function testCreatingEventWithoutEventable() {
        $objEvent = $this->eventService->create($this->user, "Test Memo");
        $this->assertInstanceOf(Event::class, $objEvent);

        $this->assertDatabaseHas("soundblock_events", [
            "event_memo"     => "Test Memo",
            "eventable_type" => null,
            "eventable_id"   => null,
            "user_id"        => $this->user->user_id,
            "user_uuid"      => $this->user->user_uuid,
            "flag_processed" => false,
        ]);
    }

    public function testEventProcessing() {
        /** @var Event $objEvent */
        $objEvent = $this->user->soundblockEvents()->create(Event::factory()->make([
            "user_uuid" => $this->user->user_uuid
        ])->setHidden([])->toArray());
        $objProcessedEvent = $this->eventService->processEvent($objEvent);

        $this->assertInstanceOf(Event::class, $objProcessedEvent);
        $this->assertDatabaseHas("soundblock_events", [
            "event_memo"     => $objEvent->event_memo,
            "user_id"        => $this->user->user_id,
            "user_uuid"      => $this->user->user_uuid,
            "flag_processed" => true,
        ]);
    }

    public function testFind() {
        /** @var Event $objEvent */
        $objEvent = $this->user->soundblockEvents()->create(Event::factory()->make([
            "user_uuid" => $this->user->user_uuid
        ])->setHidden([])->toArray());

        $objProcessedEvent = $this->eventService->find($objEvent->event_uuid);
        $this->assertInstanceOf(Event::class, $objProcessedEvent);

        $this->assertEquals($objEvent->toArray(), $objProcessedEvent->toArray());
    }

    public function testGetUnprocessed() {
        /** @var User $user */
        $user = User::factory()->create();
        $arrEvents = $user->soundblockEvents()->createMany(Event::factory()->count(5)->make([
            "user_uuid" => $this->user->user_uuid
        ])->toArray());

        $arrUnprocessedEvents = $this->eventService->getUserUnprocessedEvents($user);

        $this->assertCount($arrEvents->count(), $arrUnprocessedEvents);
    }
}
