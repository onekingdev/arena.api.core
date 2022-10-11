<?php

namespace Tests\Feature\Soundblock\Contracts;

use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Users\User;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthModel;
use Illuminate\Support\Facades\Mail;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Soundblock\Projects\Project;
use App\Models\Soundblock\Accounts\Account;
use App\Models\Users\Contact\UserContactEmail;

class AddContractTest extends TestCase {
    /**
     * @var array
     */
    private $dummyData;
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

    public function setUp(): void {
        parent::setUp();

        Queue::fake();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $objApp = App::where("app_name", "soundblock")->firstOrFail();

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid,
        ])->setAppends([])->toArray());


        $this->project->team()->create([
            "team_uuid"    => Util::uuid(),
            "project_uuid" => $this->project->project_uuid,
        ]);

        $auth = AuthModel::where("auth_name", "App.Soundblock")->firstOrFail();
        /** @var AuthGroup $authGroup */
        $authGroup = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $auth->auth_id,
            "auth_uuid"     => $auth->auth_uuid,
            "group_name"    => sprintf("App.Soundblock.Project.%s", $this->project->project_uuid),
            "group_memo"    => sprintf("App.Soundblock.Project.( %s )", $this->project->project_uuid),
            "flag_critical" => true,
        ]);

        $authGroup->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
            "group_uuid" => $authGroup->group_uuid,
            "user_uuid"  => $this->user->user_uuid,
        ]);

        $objContractPermission = AuthPermission::where("permission_name", "App.Soundblock.Account.Project.Contract")
                                               ->first();

        $authGroup->permissions()->attach($objContractPermission->permission_id, [
            "row_uuid"         => Util::uuid(),
            "group_uuid"       => $authGroup->group_uuid,
            "permission_uuid"  => $objContractPermission->permission_id,
            "permission_value" => true,
        ]);
        Passport::actingAs($this->user);

        $objUsers = User::all();

        foreach ($objUsers as $objUser) {
            if (is_null($objUser->primary_email)) {
                $objUser->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $objUser->user_uuid]));
            }

            $objUser->services()->attach($this->service->service_id, [
                "row_uuid"      => Util::uuid(),
                "service_uuid"  => $this->service->service_uuid,
                "user_uuid"     => $objUser->user_uuid,
                "flag_accepted" => true,
            ]);
        }

        $this->dummyData = [
            "members"                  => [
                [
                    "uuid"   => $objUsers[0]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 20,
                ], [
                    "uuid"   => $objUsers[1]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 20,
                ], [
                    "uuid"   => $objUsers[2]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 20,
                ], [
                    "uuid"   => $objUsers[3]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 20,
                ], [
                    "uuid"   => $objUsers[4]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 20,
                ],
            ],
            "contract_payment_message" => "test",
            "contract_name"            => "Name",
            "contract_email"           => "contract@aa.aa",
            "contract_phone"           => "123",
        ];
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddContract() {
        Mail::fake();

        $response = $this->json("POST", "/soundblock/project/{$this->project->project_uuid}/contract", $this->dummyData);
        $response->assertStatus(200)->assertJsonMissingValidationErrors();
        $arrContract = json_decode($response->getContent(), true);
        /* Check if contract created in database */
        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "service_id"       => $this->service->service_id,
            "service_uuid"     => $this->service->service_uuid,
            "project_id"       => $this->project->project_id,
            "project_uuid"     => $this->project->project_uuid,
            "flag_status"      => "Pending",
            "contract_version" => 1,
        ]);

        /*Check History Tables*/
        $this->assertDatabaseHas("soundblock_projects_contracts_history", [
            "user_id"       => $this->user->user_id,
            "user_uuid"     => $this->user->user_uuid,
            "contract_uuid" => $arrContract["data"]["contract_uuid"],
            "history_event" => "create",
        ]);

        $this->assertDatabaseHas("soundblock_projects_contracts_users_history", [
            "user_id"       => $this->user->user_id,
            "user_uuid"     => $this->user->user_uuid,
            "contract_uuid" => $arrContract["data"]["contract_uuid"],
            "history_event" => "create",
        ]);
    }

    public function testAddContractValidation() {
        $this->dummyData["members"][] = [
            "payout" => 10,
        ];

        $response = $this->json("POST", "/soundblock/project/{$this->project->project_uuid}/contract",
            $this->dummyData);
        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["members", "members.5.uuid", "members.5.role"]);
    }
}
