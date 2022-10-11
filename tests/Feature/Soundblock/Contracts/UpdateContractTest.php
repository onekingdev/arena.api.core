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
    Users\Contact\UserContactEmail,
    Users\User};
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UpdateContractTest extends TestCase {
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
     * @var Contract
     */
    private $contract;
    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    private $contractUsers;

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

        $this->contract = $this->project->contracts()->create(Contract::factory()->modifying()->make([
            "contract_uuid"    => Util::uuid(),
            "project_uuid"     => $this->project->project_uuid,
            "service_id"       => $this->service->service_id,
            "service_uuid"     => $this->service->service_uuid,
            "contract_version" => 1,
        ])->makeVisible("service_id")->toArray());

        $this->contractUsers = User::factory()->count(4)->create()->each(function (User $user) {
            $user->contracts()->attach($this->contract->contract_id, [
                "row_uuid"        => Util::uuid(),
                "contract_uuid"   => $this->contract->contract_uuid,
                "user_uuid"       => $user->user_uuid,
                "contract_status" => false,
                "user_payout"     => 25,
            ]);
        });

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

        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdate() {
        Mail::fake();

        $objUsers = User::all();

        $arrTestData = [
            "members"                  => [
                [
                    "uuid"   => $objUsers[0]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 25,
                ], [
                    "uuid"   => $objUsers[1]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 25,
                ], [
                    "uuid"   => $objUsers[2]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 25,
                ], [
                    "uuid"   => $objUsers[3]->user_uuid,
                    "role"   => "Admin",
                    "payout" => 25,
                ],
            ],
            "contract_payment_message" => "test",
            "contract_name"            => "Name",
            "contract_email"           => "contract@aa.aa",
            "contract_phone"           => "123",
            "service"                  => $this->service->service_uuid,
        ];

        $response = $this->json("PATCH", "/soundblock/project/{$this->project->project_uuid}/contract", $arrTestData);
        $response->assertStatus(200);

        $response->assertJsonFragment([
            "contract_uuid" => $this->contract->contract_uuid,
            "flag_status"   => "Modifying",
        ]);

        $this->assertDatabaseHas("soundblock_projects_contracts", [
            "contract_id"      => $this->contract->contract_id,
            "flag_status"      => "Modifying",
            "contract_version" => 2,
        ]);

        $this->assertDatabaseHas("soundblock_projects_contracts_history", [
            "user_id"       => $this->user->user_id,
            "user_uuid"     => $this->user->user_uuid,
            "contract_id"   => $this->contract->contract_id,
            "contract_uuid" => $this->contract->contract_uuid,
            "history_event" => "modifying",
        ]);
    }
}
