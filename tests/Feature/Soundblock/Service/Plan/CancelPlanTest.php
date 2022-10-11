<?php

namespace Tests\Feature\Soundblock\Service\Plan;

use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Models\Users\User;
use Laravel\Passport\Passport;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Soundblock\Accounts\AccountPlan;

class CancelPlanTest extends TestCase
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Account
     **/
    private $service;
    /**
     * @var AccountPlan
     */
    private $servicePlan;

    public function setUp(): void {
        parent::setUp();
        Queue::fake();
        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make([
            "user_uuid" => $this->user->user_uuid,
            "flag_primary" => true
        ]));

        Passport::actingAs($this->user);

        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid"         => $this->user->user_uuid
        ])->setAppends([])->toArray());

        $this->servicePlan = $this->service->plans()->create(AccountPlan::factory()->active()->make([
            "service_uuid" => $this->service->service_uuid
        ])->makeVisible("ledger_id")->toArray());
    }

    /**
     * Testing cancel user's service plan
     *
     * @return void
     */
    public function testCancelPlan() {
        $response = $this->post("soundblock/service/plan/cancel");
        $response->assertJsonStructure([
            "data" => [
                "service_uuid",
                "service_name",
                "stamp_created",
                "stamp_created_by" => ["uuid", "name"],
                "stamp_updated",
                "stamp_updated_by" => ["uuid", "name"],
                "plans" => [
                    "data" => [
                        "plan_uuid",
                        "ledger_uuid",
                        "plan_type",
                        "plan_cost",
                        "service_date",
                        "stamp_created",
                        "stamp_created_by" => ["uuid", "name"],
                        "stamp_updated",
                        "stamp_updated_by" => ["uuid", "name"]
                    ]
                ]
            ]
        ]);

        $this->assertDatabaseHas("soundblock_services", [
            "service_uuid" => $this->service->service_uuid,
            "flag_status" => "canceled"
        ]);

        $this->assertDatabaseHas("soundblock_services_plans", [
            "plan_uuid" => $this->servicePlan->plan_uuid,
            "flag_active" => false
        ]);
    }

    public function testUpgradePlan() {
        $response = $this->patch("soundblock/service/plan", [
            "type" => "Simple",
            "payment_id" => "pm_card_visa"
        ]);

        $response->assertJsonStructure([
            "data" => [
                "service_uuid",
                "service_name",
                "stamp_created",
                "stamp_created_by" => ["uuid", "name"],
                "stamp_updated",
                "stamp_updated_by" => ["uuid", "name"],
                "plans" => [
                    "data" => [
                        "plan_uuid",
                        "ledger_uuid",
                        "plan_type",
                        "plan_cost",
                        "service_date",
                        "stamp_created",
                        "stamp_created_by" => ["uuid", "name"],
                        "stamp_updated",
                        "stamp_updated_by" => ["uuid", "name"]
                    ]
                ]
            ]
        ]);

        $plan = config("constant.soundblock.plans_aliases.Simple");

        $this->assertDatabaseHas("soundblock_services", [
            "service_uuid" => $this->service->service_uuid,
            "flag_status" => "active"
        ]);

        $this->assertDatabaseHas("soundblock_services_plans", [
            "plan_uuid" => $this->servicePlan->plan_uuid,
            "flag_active" => false
        ]);

        $this->assertDatabaseHas("soundblock_services_plans", [
            "service_uuid" => $this->service->service_uuid,
            "flag_active" => true,
            "plan_type" => $plan["name"],
            "plan_cost" => $plan["price"]
        ]);
    }
}
