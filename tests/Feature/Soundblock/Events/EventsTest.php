<?php

namespace Tests\Feature\Soundblock\Events;

use App\Helpers\Util;
use App\Models\Soundblock\Event;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EventsTest extends TestCase {
    /**
     * @var User
     */
    private User $user;
    private Collection $events;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->events = $this->user->soundblockEvents()->createMany(Event::factory()->count(20)->make([
            "user_uuid" => $this->user->user_uuid,
        ])->toArray());

        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGettingUsersEvents() {
        $response = $this->get("/soundblock/events");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "current_page",
                "data" => [
                    [
                        "event_uuid",
                        "user_uuid",
                        "event_memo",
                        "flag_processed",
                        "stamp_created",
                        "stamp_updated",
                    ],
                ],
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);
    }

    public function testProcessingEvent() {
        $objEvent = $this->events->first();
        $response = $this->patch("/soundblock/event/{$objEvent->event_uuid}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "event_uuid",
                "user_uuid",
                "event_memo",
                "flag_processed",
                "stamp_created",
                "stamp_updated",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);
        $response->assertJsonFragment([
            "event_uuid"     => $objEvent->event_uuid,
            "flag_processed" => true,
        ]);
        $this->assertDatabaseHas("soundblock_events", [
            "event_id"       => $objEvent->event_id,
            "flag_processed" => true,
        ]);
    }

    public function testProcessingEventWithWrongUuid() {
        $uuid = Util::uuid();
        $response = $this->patch("/soundblock/event/{$uuid}");
        $response->assertStatus(404);
    }

}
