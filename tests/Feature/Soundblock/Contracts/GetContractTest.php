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
    Soundblock\Projects\Team,
    Users\User,
    Users\Contact\UserContactEmail};
use Laravel\Passport\Passport;
use Tests\TestCase;

class GetContractTest extends TestCase
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
    private $contractUsers;
    /**
     * @var Contract
     */
    private $contract;

    public function setUp(): void {
        parent::setUp();

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

        $auth = AuthModel::where("auth_name", "App.Soundblock")->firstOrFail();
        /** @var AuthGroup $authGroup*/
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

        /** @var Team $team*/
        $team = $this->project->team()->create([
            "team_uuid" => Util::uuid(),
            "project_uuid" => $this->project->project_uuid
        ]);

        $this->contract = $this->project->contracts()->create(Contract::factory()->make([
            "contract_uuid" => Util::uuid(),
            "project_uuid" => $this->project->project_uuid,
            "service_id" => $this->service->service_id,
            "service_uuid" => $this->service->service_uuid,
        ])->makeVisible("service_id")->toArray());

        $this->contractUsers = User::factory()->count(4)->create()->each(function (User $user) use ($team) {
            $user->contracts()->attach($this->contract->contract_id, [
                "row_uuid" => Util::uuid(),
                "contract_uuid" => $this->contract->contract_uuid,
                "user_uuid" => $user->user_uuid,
                "contract_status" => false,
                "user_payout" => 25,
            ]);
            $user->emails()->create(UserContactEmail::factory()->primary()->make([
                "row_uuid" => Util::uuid(),
                "user_uuid" => $user->user_uuid
            ])->makeVisible("row_uuid", "user_uuid")->toArray());

            $team->users()->attach($user->user_id, [
                "row_uuid" => Util::uuid(),
                "team_uuid" => $team->team_uuid,
                "user_uuid" => $user->user_uuid,
                "user_role" => "Admin",
                "user_payout" => 25
            ]);
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGettingContract()
    {
        Passport::actingAs($this->user);
        $response = $this->get("soundblock/project/{$this->project->project_uuid}/contract");
        $response->assertStatus(200);
        $response->assertJsonFragment([
            "contract_uuid" => $this->contract->contract_uuid
        ]);
    }

    public function testGettingContractWithoutAccess() {
        $objUser = User::factory()->create();
        Passport::actingAs($objUser);
        $response = $this->get("soundblock/project/{$this->project->project_uuid}/contract");
        $response->assertStatus(403);
    }
}
