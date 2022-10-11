<?php

namespace Tests\Feature\Soundblock\Project;

use Faker\Factory;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Helpers\Util;
use App\Helpers\Constant;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use Laravel\Passport\Passport;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Core\Auth\{AuthGroup, AuthModel};
use App\Models\Soundblock\{Invites, Projects\Project, Projects\Team, Accounts\Account};

class TeamTest extends TestCase {
    private Project $project;
    private Team $team;
    /**
     * @var User
     */
    private User $user;
    private Account $service;

    /**
     * @var User[]
     */
    private array $users;

    public function setUp(): void {
        parent::setUp();
        Queue::fake();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid,
        ])->setAppends([])->toArray());
        /** @var AuthModel $objAuth */
        $objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        $objApp = $objAuth->app;

        $objAuthGroupProject = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $objAuth->auth_id,
            "auth_uuid"     => $objAuth->auth_uuid,
            "group_name"    => Util::makeGroupName($objAuth, "project", $this->project),
            "group_memo"    => Util::makeGroupMemo($objAuth, "project", $this->project),
            "flag_critical" => true,
        ]);

        $objAuthGroupService = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $objAuth->auth_id,
            "auth_uuid"     => $objAuth->auth_uuid,
            "group_name"    => Util::makeGroupName($objAuth, "service", $this->service),
            "group_memo"    => Util::makeGroupMemo($objAuth, "service", $this->service),
            "flag_critical" => true,
        ]);

        $this->user->groups()->attach($objAuthGroupProject->group_id, [
            "row_uuid"   => Util::uuid(),
            "group_uuid" => $objAuthGroupProject->group_uuid,
            "user_uuid"  => $this->user->user_uuid,
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
        ]);

        $this->user->groups()->attach($objAuthGroupService->group_id, [
            "row_uuid"   => Util::uuid(),
            "group_uuid" => $objAuthGroupService->group_uuid,
            "user_uuid"  => $this->user->user_uuid,
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
        ]);

        foreach (Constant::project_level_permissions() as $permission) {
            $objAuthGroupProject->permissions()->attach($permission->permission_id, [
                "row_uuid"         => Util::uuid(),
                "group_uuid"       => $objAuthGroupProject->group_uuid,
                "permission_uuid"  => $permission->permission_uuid,
                "permission_value" => true,
            ]);
        }

        foreach (Constant::project_level_permissions() as $permission) {
            $objAuthGroupService->permissions()->attach($permission->permission_id, [
                "row_uuid"         => Util::uuid(),
                "group_uuid"       => $objAuthGroupService->group_uuid,
                "permission_uuid"  => $permission->permission_uuid,
                "permission_value" => true,
            ]);
        }

        foreach (Constant::user_level_permissions() as $objPermission) {
            $this->user->permissionsInGroup()->attach($objPermission->permission_id, [
                "row_uuid"         => Util::uuid(),
                "group_id"         => $objAuthGroupProject->group_id,
                "group_uuid"       => $objAuthGroupProject->group_uuid,
                "user_uuid"        => $this->user->user_uuid,
                "permission_uuid"  => $objPermission->permission_uuid,
                "permission_value" => true,
            ]);
        }

        foreach (Constant::user_level_permissions() as $objPermission) {
            $this->user->permissionsInGroup()->attach($objPermission->permission_id, [
                "row_uuid"         => Util::uuid(),
                "group_id"         => $objAuthGroupService->group_id,
                "group_uuid"       => $objAuthGroupService->group_uuid,
                "user_uuid"        => $this->user->user_uuid,
                "permission_uuid"  => $objPermission->permission_uuid,
                "permission_value" => true,
            ]);
        }

        foreach (Constant::account_level_permissions() as $objPermission) {
            $this->user->permissionsInGroup()->attach($objPermission->permission_id, [
                "row_uuid"         => Util::uuid(),
                "group_id"         => $objAuthGroupProject->group_id,
                "group_uuid"       => $objAuthGroupProject->group_uuid,
                "user_uuid"        => $this->user->user_uuid,
                "permission_uuid"  => $objPermission->permission_uuid,
                "permission_value" => true,
            ]);
        }

        foreach (Constant::account_level_permissions() as $objPermission) {
            $this->user->permissionsInGroup()->attach($objPermission->permission_id, [
                "row_uuid"         => Util::uuid(),
                "group_id"         => $objAuthGroupService->group_id,
                "group_uuid"       => $objAuthGroupService->group_uuid,
                "user_uuid"        => $this->user->user_uuid,
                "permission_uuid"  => $objPermission->permission_uuid,
                "permission_value" => true,
            ]);
        }

        $this->team = $this->project->team()->create([
            "team_uuid"    => Util::uuid(),
            "project_uuid" => $this->project->project_uuid,
        ]);

        User::factory()->count(5)->create()->each(function (User $user) {
            $this->users[] = $user;

            $this->team->users()->attach($user->user_id, [
                "row_uuid"  => Util::uuid(),
                "team_uuid" => $this->team->team_uuid,
                "user_uuid" => $user->user_uuid,
            ]);
        });

        $this->team->invite()->createMany(Invites::factory()->count(5)->make()->toArray());

        $this->team->users()->attach($this->user->user_id, [
            "row_uuid"  => Util::uuid(),
            "team_uuid" => $this->team->team_uuid,
            "user_uuid" => $this->user->user_uuid,
        ]);

        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetTeam() {
        $response = $this->get("/soundblock/project/{$this->project->project_uuid}/team");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "permissions_in_team",
                "team" => [
                    "team_uuid",
                    "project_uuid",
                    "stamp_created",
                    "stamp_updated",
                    "users"  => [
                        [
                            "user_uuid",
                            "name",
                            "user_role",
                            "user_auth_email",
                            "user_payout",
                            "contract_status",
                            "is_owner",
                        ],
                    ],
                    "invite" => [
                        [
                            "invite_uuid",
                            "invite_email",
                            "invite_name",
                            "invite_role",
                            "invite_payout",
                            "stamp_created",
                            "stamp_created_by",
                            "stamp_updated",
                            "stamp_updated_by",
                        ],
                    ],
                ],
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment([
            "team_uuid"    => $this->team->team_uuid,
            "project_uuid" => $this->project->project_uuid,
        ]);

        $arrResponse = json_decode($response->getContent(), true);

        $intUsersCount = $this->team->users()->count();
        $intInvitesCount = $this->team->invite()->count();

        $this->assertCount($intUsersCount, $arrResponse["data"]["team"]["users"]);
        $this->assertCount($intInvitesCount, $arrResponse["data"]["team"]["invite"]);
    }

    public function testAddExistingUser() {
        /** @var User $objUser */
        $objUser = User::factory()->create();

        $objEmail = $objUser->emails()->create(UserContactEmail::factory()->primary()->verified()->make([
            "row_uuid" => Util::uuid(),
        ])->setHidden([])->toArray());

        $arrPermissions = [];

        foreach (Constant::project_level_permission_names() as $permissionName) {
            $arrPermissions[] = [
                "permission_name"  => $permissionName,
                "permission_value" => true,
            ];
        }

        $intTeamCount = $this->team->users()->count();

        $response = $this->post("/soundblock/project/team", [
            "first_name"      => $objUser->name,
            "last_name"       => "Test",
            "user_auth_email" => $objEmail->user_auth_email,
            "user_role"       => "Role",
            "team"            => $this->team->team_uuid,
            "permissions"     => $arrPermissions,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data"   => [
                "user_uuid",
                "avatar_name",
                "stamp_created",
                "stamp_created_by" => [
                    "uuid",
                    "name",
                ],
                "stamp_updated",
                "stamp_updated_by" => [
                    "uuid",
                    "name",
                ],
                "name",
                "primary_email"    => [
                    "user_auth_email",
                    "flag_primary",
                    "flag_verified",
                ],
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment([
            "user_uuid" => $objUser->user_uuid,
        ]);

        $this->assertDatabaseHas("soundblock_projects_teams_users", [
            "team_id"   => $this->team->team_id,
            "team_uuid" => $this->team->team_uuid,
            "user_id"   => $objUser->user_id,
            "user_uuid" => $objUser->user_uuid,
            "user_role" => "Role",
        ]);

        $this->assertCount($intTeamCount + 1, $this->team->users);
    }

    public function testAddNewUser() {
        $arrPermissions = [];

        foreach (Constant::project_level_permission_names() as $permissionName) {
            $arrPermissions[] = [
                "permission_name"  => $permissionName,
                "permission_value" => true,
            ];
        }

        $faker = Factory::create();

        $strName = $faker->name;
        $strEmail = $faker->email;

        $response = $this->post("/soundblock/project/team", [
            "first_name"      => $strName,
            "last_name"       => "Test",
            "user_auth_email" => $strEmail,
            "user_role"       => "Role",
            "team"            => $this->team->team_uuid,
            "permissions"     => $arrPermissions,
        ]);
        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data"   => [
                "invite_uuid",
                "name",
                "primary_email" => [
                    "user_auth_email",
                    "flag_primary",
                    "flag_verified",
                ],
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
            "name" => $strName . " Test",
        ]);

        $response->assertJsonFragment([
            "user_auth_email" => $strEmail,
        ]);

        $this->assertDatabaseHas("soundblock_invites", [
            "model_class"  => Team::class,
            "model_id"     => $this->team->team_id,
            "invite_name"  => $strName . " Test",
            "invite_email" => $strEmail,
            "invite_role"  => "Role",
        ]);
    }

    public function testAddMemberValidationError() {
        $response = $this->post("/soundblock/project/team");
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(["user_uuid", "first_name", "last_name", "user_auth_email", "user_role", "team"]);
    }

    public function testDeleteMember() {
        $objUser = Arr::random($this->users);
        $intCountBeforeDelete = $this->team->users()->count();

        $response = $this->delete("/soundblock/project/{$this->project->project_uuid}/team/member/{$objUser->user_uuid}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing("soundblock_projects_teams_users", [
            "team_id"   => $this->team->team_id,
            "team_uuid" => $this->team->team_uuid,
            "user_id"   => $objUser->user_id,
            "user_uuid" => $objUser->user_uuid,
        ]);

        $this->assertCount($intCountBeforeDelete - 1, $this->team->users);

    }

    public function testDeleteMembers() {
        $arrUsersUuid = Arr::pluck($this->users, "user_uuid");

        $intCountBeforeDelete = $this->team->users()->count();

        $response =  $this->delete("/soundblock/project/{$this->project->project_uuid}/team/members", [
            "users" => $arrUsersUuid
        ]);
        $response->assertStatus(204);

        foreach ($this->users as $objUser) {
            $this->assertDatabaseMissing("soundblock_projects_teams_users", [
                "team_id"   => $this->team->team_id,
                "team_uuid" => $this->team->team_uuid,
                "user_id"   => $objUser->user_id,
                "user_uuid" => $objUser->user_uuid,
            ]);
        }

        $this->assertCount($intCountBeforeDelete - count($arrUsersUuid), $this->team->users);
    }
}
