<?php

namespace Tests\Feature\Auth;

use App\Mail\Soundblock\EmailVerification;
use App\Models\Users\User;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SingUpTest extends TestCase {
    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $_SERVER["PASSWORD_CLIENT_SECRET"] = DB::table("oauth_clients")->where("id", 2)->value("secret");
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessSignUp() {
        Mail::fake();

        $userData = [
            "name_first"                 => "TestName",
            "email"                      => "signupsuccess" . time() . "@arena.com",
            "user_password"              => "password123",
            "user_password_confirmation" => "password123",
        ];

        $response = $this->post("/core/auth/signup", $userData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "user",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $this->assertDatabaseHas("users_contact_emails", ["user_auth_email" => $userData["email"], "flag_primary" => true]);

        $objEmail = UserContactEmail::where("user_auth_email", $userData["email"])->first();

        $this->assertDatabaseHas("users", ["user_id" => $objEmail->user_id, "name_first" => $userData["name_first"]]);

        Mail::assertSent(EmailVerification::class);
    }

    public function testSignUpValidationFail() {
        $response = $this->post("/core/auth/signup", []);

        $response->assertStatus(422);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonValidationErrors(["name_first", "email", "user_password"]);
    }

    public function testSignUpNotUniqueEmailFail() {
        $strUserEmail = "signupnotunique" . time() . "@arena.com";
        /** @var User $user */
        $user = User::factory()->create();
        $user->emails()->save(UserContactEmail::factory()->make([
            "user_uuid"       => $user->user_uuid,
            "flag_primary"    => true,
            "user_auth_email" => $strUserEmail,
        ]));

        $userData = [
            "email"                      => $strUserEmail,
            "name_first"                 => "TestName",
            "user_password"              => "password123",
            "user_password_confirmation" => "password123",
        ];

        $response = $this->post("/core/auth/signup", $userData);
        $response->assertJsonFragment(["message" => "The given data was invalid."]);
        $response->assertJsonFragment(["email" => ["The email has already been taken."]]);
        $response->assertJsonValidationErrors(["email"]);
    }
}
