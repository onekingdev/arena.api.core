<?php

namespace Tests\Feature\Soundblock\Invite;

use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthModel;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Users\User;
use App\Helpers\Util;
use Illuminate\Support\Str;
use App\Models\Soundblock\{Projects\Contracts\Contract, Invites, Projects\Project, Accounts\Account};

class InviteContractTest extends TestCase {
    private Invites $invite;
    private Account $service;
    private Project $project;
    private Contract $contract;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";
        $_SERVER["PASSWORD_CLIENT_SECRET"] = DB::table("oauth_clients")->where("id", 2)
           ->value("secret");

        $user = User::factory()->create();

        $this->service = $user->service()->create(Account::factory()->make([
            "user_uuid" => $user->user_uuid,
        ])->setAppends([])->toArray());

        $this->project = $this->service->projects()->create(Project::factory()->make([
            "service_uuid" => $this->service->service_uuid,
        ])->setAppends([])->toArray());

        $this->contract = $this->project->contracts()->create(Contract::factory()->make([
            "contract_uuid" => Util::uuid(),
            "project_uuid"  => $this->project->project_uuid,
            "service_id"    => $this->service->service_id,
            "service_uuid"  => $this->service->service_uuid,
        ])->makeVisible("service_id")->toArray());

        $this->invite = $this->contract->invites()->create(Invites::factory()->make([
            "invite_payout" => 20,
            "invite_role" => "Admin",
        ])->toArray());

        $auth = AuthModel::where("auth_name", "App.Soundblock")->first();

        AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $auth->auth_id,
            "auth_uuid"     => $auth->auth_uuid,
            "group_name"    => "App.Soundblock.Project." . $this->project->project_uuid,
            "group_memo"    => "App.Soundblock.Project." . $this->project->project_uuid,
            "flag_critical" => true,
        ]);

        AuthGroup::create([
            "group_uuid"    => Util::uuid(),
            "auth_id"       => $auth->auth_id,
            "auth_uuid"     => $auth->auth_uuid,
            "group_name"    => "App.Soundblock.Account." . $this->service->service_uuid,
            "group_memo"    => "App.Soundblock.Account." . $this->service->service_uuid,
            "flag_critical" => true,
        ]);
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
                "payout"       => 20,
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
        $_ENV["PASSWORD_CLIENT_SECRET"] = DB::table("oauth_clients")->where("id", 2)->value("secret");

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

        $this->assertDatabaseHas("soundblock_invites", [
            "invite_id" => $this->invite->invite_id,
            "flag_used" => true,
        ]);

        $this->assertDatabaseHas("users", [
            "name_first" => $userData["name_first"],
        ]);

        $this->assertDatabaseHas("users_contact_emails", [
            "user_auth_email" => $userData["email"],
            "flag_primary"    => false,
        ]);

        $this->assertDatabaseHas("users_contact_emails", [
            "user_auth_email" => $this->invite->invite_email,
            "flag_primary"    => true,
        ]);
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
        $_ENV["PASSWORD_CLIENT_SECRET"] = DB::table("oauth_clients")->where("id", 2)->value("secret");

        $invite = $this->contract->invites()->create(Invites::factory()->make([
            "invite_role" => "Admin",
            "invite_payout" => "Admin",
        ])->toArray());

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
        $response = $this->post("/soundblock/invite/{$invite->invite_hash}/signin", $reqData);

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

        $this->assertDatabaseHas("soundblock_invites", [
            "invite_id" => $invite->invite_id,
            "flag_used" => true,
        ]);

        $this->assertDatabaseHas("users_contact_emails", [
            "user_auth_email" => $invite->invite_email,
            "flag_primary"    => false,
        ]);
    }
}
