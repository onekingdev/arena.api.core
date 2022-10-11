<?php

namespace Tests\Feature\Soundblock\Contracts;

use App\Helpers\Util;
use App\Models\{Core\Auth\AuthGroup,
    Core\Auth\AuthModel,
    Core\App,
    Core\Auth\AuthPermission,
    Soundblock\Projects\Contracts\Contract,
    Soundblock\Projects\Project,
    Soundblock\Accounts\Account,
    Users\User,
    Users\Contact\UserContactEmail};
use Illuminate\Support\Facades\Queue;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CompletelyCycleTest extends TestCase
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Account
     */
    private $service;
    /**
     * @var Project
     */
    private $project;
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $testUsers;

    public function setUp(): void {
        parent::setUp();
        Queue::fake();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $objApp = App::where("app_name", "soundblock")->firstOrFail();

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid"         => $this->user->user_uuid
        ])->setAppends([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid
        ])->setAppends([])->toArray());

        $this->project->team()->create([
            "team_uuid" => Util::uuid(),
            "project_uuid" => $this->project->project_uuid
        ]);

        $auth = AuthModel::where("auth_name", "App.Soundblock")->firstOrFail();
        /** @var AuthGroup $authGroup */
        $authGroup = AuthGroup::create([
            "group_uuid" => Util::uuid(),
            "auth_id" => $auth->auth_id,
            "auth_uuid" => $auth->auth_uuid,
            "group_name" => sprintf("App.Soundblock.Project.%s", $this->project->project_uuid),
            "group_memo" => sprintf("App.Soundblock.Project.( %s )", $this->project->project_uuid),
            "flag_critical" => true
        ]);

        $authGroup->users()->attach($this->user->user_id, [
            "row_uuid" => Util::uuid(),
            "app_id" => $objApp->app_id,
            "app_uuid" => $objApp->app_uuid,
            "group_uuid" => $authGroup->group_uuid,
            "user_uuid" => $this->user->user_uuid,
        ]);


        $objContractPermission = AuthPermission::where("permission_name", "App.Soundblock.Account.Project.Contract")
                                               ->first();

        $authGroup->permissions()->attach($objContractPermission->permission_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroup->group_uuid,
            "permission_uuid"  => $objContractPermission->permission_id,
            "permission_value" => true,
        ]);

        $this->testUsers = User::factory()->count(5)->create()->each(function (User $user) {
            $user->emails()->create(UserContactEmail::factory()->make([
                "row_uuid" => Util::uuid(),
                "user_uuid" => $user->user_uuid,
                "flag_primary" => true
            ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

            $user->services()->attach($this->service->service_id, [
                "row_uuid"      => Util::uuid(),
                "service_uuid"  => $this->service->service_uuid,
                "user_uuid"     => $user->user_uuid,
                "flag_accepted" => true,
            ]);
        });

    }

    /**
     * Test full cycle of contract's changes
     *
     * @return void
     */
    public function testContractCycle() {
        Passport::actingAs($this->user);

        $arrTestCreateData = [];

        foreach($this->testUsers as $testUser) {
            $arrTestCreateData["members"][] = [
                "uuid" => $testUser->user_uuid,
                "role" => "Admin",
                "payout" => 100 / count($this->testUsers),
            ];
        }

        $response = $this->json("POST", "/soundblock/project/{$this->project->project_uuid}/contract", $arrTestCreateData);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "service_id" => $this->service->service_id,
            "service_uuid" => $this->service->service_uuid,
            "project_id" => $this->project->project_id,
            "project_uuid" => $this->project->project_uuid,
            "flag_status" => "Pending",
            "contract_version" => 1
        ]);

        $arrCreateResponse = json_decode($response->getContent(), true);
        $objContract = Contract::where("contract_uuid", $arrCreateResponse["data"]["contract_uuid"])->first();

        /* Check if users exists in database */
        foreach($this->testUsers as $member) {
            $this->assertDatabaseHas("soundblock_projects_contracts_users", [
                "contract_id" => $objContract->contract_id,
                "user_id" => $member->user_id,
                "contract_status" => "Pending",
                "contract_version" => 1
            ]);
        }

        $objUserTest = $this->testUsers->first();

        Passport::actingAs($objUserTest);

        $response = $this->json("PATCH", "soundblock/project/contract/{$objContract->contract_uuid}/reject");
        $response->assertStatus(200);

        $this->assertDatabaseHas("soundblock_projects_contracts_users", [
            "contract_id" => $objContract->contract_id,
            "user_id" => $objUserTest->user_id,
            "contract_status" => "Rejected",
            "contract_version" => 1
        ]);

        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "contract_id" => $objContract->contract_id,
            "flag_status" => "Rejected"
        ]);


        Passport::actingAs($this->user);

        $arrTestUpdateData = [];

        $updateTestUsers = $this->testUsers->skip(1);

        foreach($updateTestUsers as $testUser) {
            $arrTestUpdateData["members"][] = [
                "uuid" => $testUser->user_uuid,
                "role" => "Admin",
                "payout" => 100 / count($updateTestUsers),
            ];
        }

        $arrTestUpdateData["service"] = $this->service->service_uuid;

        $response = $this->json("PATCH", "/soundblock/project/{$this->project->project_uuid}/contract", $arrTestUpdateData);
        $response->assertStatus(200);

        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "contract_id" => $objContract->contract_id,
            "flag_status" => "Modifying",
            "contract_version" => 2
        ]);

        $this->assertDatabaseHas("soundblock_projects_contracts_history", [
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid,
            "contract_id" => $objContract->contract_id,
            "contract_uuid" => $objContract->contract_uuid,
            "history_event" => "modifying"
        ]);

        foreach($updateTestUsers as $member) {
            $this->assertDatabaseHas("soundblock_projects_contracts_users", [
                "contract_id" => $objContract->contract_id,
                "user_id" => $member->user_id,
                "contract_status" => "Pending",
                "contract_version" => 2
            ]);
        }

        foreach($updateTestUsers as $user) {
            Passport::actingAs($user);

            $response = $this->json("PATCH", "soundblock/project/contract/{$objContract->contract_uuid}/accept");

            $response->assertStatus(200);

            $this->assertDatabaseHas("soundblock_projects_contracts_users", [
                "contract_id" => $objContract->contract_id,
                "user_id" => $user->user_id,
                "contract_status" => "Accepted",
                "contract_version" => 2
            ]);

            $this->assertDatabaseHas("soundblock_projects_contracts_users_history", [
                "user_id" => $user->user_id,
                "user_uuid" => $user->user_uuid,
                "contract_id" => $objContract->contract_id,
                "contract_uuid" => $objContract->contract_uuid,
                "history_event" => "accept"
            ]);
        }

        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "contract_id" => $objContract->contract_id,
            "flag_status" => "Active",
            "contract_version" => 2
        ]);

        $this->assertDatabaseHas("soundblock_projects_contracts_history", [
            "user_id" => $updateTestUsers->last()->user_id,
            "user_uuid" => $updateTestUsers->last()->user_uuid,
            "contract_id" => $objContract->contract_id,
            "contract_uuid" => $objContract->contract_uuid,
            "history_event" => "active"
        ]);

        $arrRejectTestData = [];

        $updateRejectTestUsers = $updateTestUsers->skip(2);

        foreach($updateRejectTestUsers as $testUser) {
            $arrRejectTestData["members"][] = [
                "uuid" => $testUser->user_uuid,
                "role" => "Admin",
                "payout" => 100 / count($updateRejectTestUsers),
            ];
        }

        Passport::actingAs($this->user);

        $response = $this->json("PATCH", "/soundblock/project/{$this->project->project_uuid}/contract", $arrRejectTestData);
        $response->assertStatus(200);

        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "contract_id" => $objContract->contract_id,
            "flag_status" => "Modifying",
            "contract_version" => 3
        ]);

        $objUserTest = $updateRejectTestUsers->first();

        Passport::actingAs($objUserTest);

        $response = $this->json("PATCH", "soundblock/project/contract/{$objContract->contract_uuid}/reject");
        $response->assertStatus(200);

        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "contract_id" => $objContract->contract_id,
            "flag_status" => "Active",
            "contract_version" => 2
        ]);
    }
}
