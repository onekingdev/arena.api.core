<?php

namespace Tests\Feature\Soundblock\Invite;

use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthModel;
use App\Models\Core\Auth\AuthPermission;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Helpers\Util;
use App\Helpers\Constant;
use Illuminate\Support\Str;
use App\Models\Users\{Contact\UserContactEmail, User};
use App\Models\Soundblock\{Invites, Projects\Project, Projects\Team, Accounts\Account};

class InviteTeamTest extends TestCase {
    private User $user;
    private Account $service;
    private Project $project;
    private Team $team;
    private Invites $invite;
    private AuthGroup $objAuthGroup;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";
        $_SERVER["PASSWORD_CLIENT_SECRET"] = DB::table("oauth_clients")->where("id", 2)
                                               ->value("secret");

        $this->user = User::factory()->create();

        $this->service = $this->user->service()->create(Account::factory()->make([
            "user_uuid" => $this->user->user_uuid,
        ])->setAppends([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid,
        ])->setAppends([])->toArray());

        /** @var AuthModel $objAuth */
        $objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        $objApp = $objAuth->app;

        $this->objAuthGroup = AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $objAuth->auth_id,
            "auth_uuid"     => $objAuth->auth_uuid,
            "group_name"    => Util::makeGroupName($objAuth, "project", $this->project),
            "group_memo"    => Util::makeGroupMemo($objAuth, "project", $this->project),
            "flag_critical" => true,
        ]);

        AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $objAuth->auth_id,
            "auth_uuid"     => $objAuth->auth_uuid,
            "group_name"    => Util::makeGroupName($objAuth, "service", $this->service),
            "group_memo"    => Util::makeGroupMemo($objAuth, "service", $this->service),
            "flag_critical" => true,
        ]);

        $this->team = $this->project->team()->create([
            "team_uuid"    => Util::uuid(),
            "project_uuid" => $this->project->project_uuid,
        ]);

        $arrPermissions = [];

        foreach (Constant::project_level_permission_names() as $permissionName) {
            $arrPermissions[] = [
                "permission_name"  => $permissionName,
                "permission_value" => true,
            ];
        }

        $this->invite = $this->team->invite()->create(Invites::factory()->make([
            "invite_permissions" => $arrPermissions,
            "invite_role"        => "Role",
            "invite_payout"      => 5.0,
        ])->setHidden([])->toArray());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInviteGet() {
        $response = $this->get("/soundblock/invite/{$this->invite->invite_hash}");

        $response->assertJsonStructure([
            "data" => [
                "invite_uuid",
                "invite_hash",
                "invite_email",
                "invite_name",
                "invite_role",
                "payout",
                "project" => [
                    "project_uuid",
                    "project_title",
                    "project_type",
                    "project_date",
                    "project_artwork",
                ],
                "service" => [
                    "service_uuid",
                    "service_name",
                ],
            ],
        ]);

        $response->assertJson([
            "data" => [
                "invite_uuid"  => $this->invite->invite_uuid,
                "invite_hash"  => $this->invite->invite_hash,
                "invite_email" => $this->invite->invite_email,
                "invite_name"  => $this->invite->invite_name,
                "invite_role"  => $this->invite->invite_role,
                "payout"       => intval($this->invite->invite_payout),
                "project"      => [
                    "project_uuid"    => $this->project->project_uuid,
                    "project_title"   => $this->project->project_title,
                    "project_type"    => $this->project->project_type,
                    "project_date"    => $this->project->project_date,
                ],
                "service"      => [
                    "service_uuid" => $this->service->service_uuid,
                    "service_name" => $this->service->service_name,
                ],
            ],
        ]);
    }

    public function testInviteGetFail() {
        $invalidHash = Str::random(32);
        $response = $this->get("/soundblock/invite/{$invalidHash}");
        $response->assertStatus(404);
        $response->assertJsonFragment([
            "message" => "Invalid Invite Hash",
        ]);
    }

    public function testInviteSignUp() {
        $userData = [
            "name_first"                 => "TestName",
            "email"                      => "invitetestsuccess" . time() . "@arena.com",
            "user_password"              => "invitePassword",
            "user_password_confirmation" => "invitePassword",
        ];

        $response = $this->post("/soundblock/invite/{$this->invite->invite_hash}/signup", $userData);

        $response->assertJsonStructure([
            "data"   => [
                "auth" => [
                    "token_type",
                    "expires_in",
                    "access_token",
                    "refresh_token",
                ],
                "user",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $arrResponse = json_decode($response->getContent(), true);

        $this->assertDatabaseHas("soundblock_invites", [
            "invite_id" => $this->invite->invite_id,
            "flag_used" => true,
        ]);

        $this->assertDatabaseHas("users", [
            "name_first" => $userData["name_first"],
            "user_uuid"  => $arrResponse["data"]["user"],
        ]);

        $this->assertDatabaseHas("users_contact_emails", [
            "user_auth_email" => $userData["email"],
            "flag_primary"    => false,
            "user_uuid"       => $arrResponse["data"]["user"],

        ]);

        $this->assertDatabaseHas("users_contact_emails", [
            "user_auth_email" => $this->invite->invite_email,
            "flag_primary"    => true,
            "user_uuid"       => $arrResponse["data"]["user"],
        ]);

        $this->assertDatabaseHas("soundblock_projects_teams_users", [
            "team_id"   => $this->team->team_id,
            "team_uuid" => $this->team->team_uuid,
            "user_uuid" => $arrResponse["data"]["user"],
        ]);

        foreach ($this->invite->invite_permissions as $permission) {
            $objPermission = AuthPermission::where("permission_name", $permission["permission_name"])->first();

            $this->assertDatabaseHas("core_auth_permissions_groups_users", [
                "permission_id"    => $objPermission->permission_id,
                "permission_uuid"  => $objPermission->permission_uuid,
                "permission_value" => $permission["permission_value"],
                "group_id"         => $this->objAuthGroup->group_id,
                "group_uuid"       => $this->objAuthGroup->group_uuid,
                "user_uuid"        => $arrResponse["data"]["user"],
            ]);
        }
    }

    public function testInviteSignUpValidationFail() {
        $response = $this->post("/soundblock/invite/{$this->invite->invite_hash}/signup", []);
        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["name_first", "email", "user_password"]);
    }

    public function testInviteSignUpInvalidHashFail() {
        $invalidHash = Str::random(32);
        $userData = [
            "name_first"                 => "TestName",
            "email"                      => "invitetestvalidfail" . time() . "@arena.com",
            "user_password"              => "invitePassword",
            "user_password_confirmation" => "invitePassword",
        ];

        $response = $this->post("/soundblock/invite/{$invalidHash}/signup", $userData);

        $response->assertStatus(404);
        $response->assertJsonFragment([
            "message" => "Invalid Invite Hash",
        ]);
    }

    public function testInviteSignUpUsedHashFail() {
        $this->invite->flag_used = true;
        $this->invite->save();

        $userData = [
            "name_first"                 => "TestName",
            "email"                      => "invitetesthashfail" . time() . "@arena.com",
            "user_password"              => "invitePassword",
            "user_password_confirmation" => "invitePassword",
        ];

        $response = $this->post("/soundblock/invite/{$this->invite->invite_hash}/signup", $userData);

        $response->assertStatus(403);
        $response->assertJsonFragment([
            "message" => "This invite has already used.",
        ]);
    }

    public function testInviteSignIn() {
        /** @var User $user */
        $user = User::factory()->create();
        $objEmail = $user->emails()->save(UserContactEmail::factory()->verified()->make([
            "user_uuid"    => $user->user_uuid,
            "flag_primary" => true,
        ]));

        $reqData = [
            "user"     => $objEmail->user_auth_email,
            "password" => "password",
        ];
        $response = $this->post("/soundblock/invite/{$this->invite->invite_hash}/signin", $reqData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "auth" => [
                    "token_type",
                    "expires_in",
                    "access_token",
                    "refresh_token",
                ],
                "user",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $arrResponse = json_decode($response->getContent(), true);

        $this->assertDatabaseHas("soundblock_invites", [
            "invite_id" => $this->invite->invite_id,
            "flag_used" => true,
        ]);

        $this->assertDatabaseHas("users_contact_emails", [
            "user_auth_email" => $this->invite->invite_email,
            "flag_primary"    => false,
        ]);

        $this->assertDatabaseHas("soundblock_projects_teams_users", [
            "team_id"   => $this->team->team_id,
            "team_uuid" => $this->team->team_uuid,
            "user_uuid" => $arrResponse["data"]["user"],
        ]);

        foreach ($this->invite->invite_permissions as $permission) {
            $objPermission = AuthPermission::where("permission_name", $permission["permission_name"])->first();

            $this->assertDatabaseHas("core_auth_permissions_groups_users", [
                "permission_id"    => $objPermission->permission_id,
                "permission_uuid"  => $objPermission->permission_uuid,
                "permission_value" => $permission["permission_value"],
                "group_id"         => $this->objAuthGroup->group_id,
                "group_uuid"       => $this->objAuthGroup->group_uuid,
                "user_uuid"        => $arrResponse["data"]["user"],
            ]);
        }
    }
}
