<?php

namespace Tests\Feature\Auth\Email;

use App\Helpers\Util;
use App\Mail\Soundblock\EmailVerification;
use App\Models\BaseModel;
use App\Models\Users\User;
use App\Models\Users\Contact\UserContactEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;
use Tests\TestCase;

class VerificationTest extends TestCase {
    /**
     * @var User
     */
    private $user;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.soundblock.web";

        $this->user = User::factory()->create();

        Passport::actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testSuccessfullyVerification() {
        $objEmail = $this->user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $this->user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid", "verification_hash"])->toArray());

        $response = $this->patch("core/email/{$objEmail->verification_hash}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "user_auth_email",
                "flag_primary",
                "flag_verified",
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
                "stamp_email",
                "stamp_email_by"   => [
                    "uuid",
                    "name",
                ],
            ],
        ]);

        $response->assertJsonFragment([
            "user_auth_email" => $objEmail->user_auth_email,
            "flag_verified"   => true,
        ]);

        $this->assertDatabaseHas("users_contact_emails", ["row_id" => $objEmail->row_id, "flag_verified" => true]);
    }

    public function testVerificationInvalidHash() {
        $response = $this->patch("core/email/invalidString");

        $response->assertStatus(404);
        $response->assertJsonFragment([
            "message" => "Email Not Found.",
        ]);
    }

    public function testAlreadyVerifiedEmail() {
        $objEmail = $this->user->emails()->create(UserContactEmail::factory()->verified()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $this->user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid", "verification_hash"])->toArray());

        $response = $this->patch("core/email/{$objEmail->verification_hash}");
        $response->assertStatus(400);
        $response->assertJsonFragment([
            "message" => "This email has already been verified.",
        ]);
    }

    public function testClearEmailsCommand() {
        $objNotVerifiedEmail = $this->user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $this->user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid", "verification_hash"])->toArray());
        $objNotVerifiedEmail->{BaseModel::CREATED_AT} = Carbon::now()->subDays(3);
        $objNotVerifiedEmail->save();

        $objVerifiedEmail = $this->user->emails()->create(UserContactEmail::factory()->verified()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $this->user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid", "verification_hash"])->toArray());
        $objVerifiedEmail->{BaseModel::CREATED_AT} = Carbon::now()->subDays(3);
        $objVerifiedEmail->save();

        $this->artisan("user:emails:clear");

        $this->assertSoftDeleted("users_contact_emails", ["row_id" => $objNotVerifiedEmail->row_id], null, BaseModel::DELETED_AT);
        $this->assertDatabaseHas("users_contact_emails", ["row_id" => $objVerifiedEmail->row_id, BaseModel::DELETED_AT => null]);
    }

    public function testSendVerificationMessage() {
        Mail::fake();

        $objNotVerifiedEmail = $this->user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"     => Util::uuid(),
            "user_uuid"    => $this->user->user_uuid,
            "flag_primary" => true,
        ])->makeVisible(["row_uuid", "user_uuid", "verification_hash"])->toArray());

        $response = $this->post("core/email/{$objNotVerifiedEmail->row_uuid}/verify");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "email_uuid",
                "user_auth_email",
                "flag_primary",
                "flag_verified",
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
                "stamp_email",
                "stamp_email_by",
            ],
        ]);

        $response->assertJsonFragment([
            "user_auth_email" => $objNotVerifiedEmail->user_auth_email,
        ]);

        Mail::assertSent(EmailVerification::class);
    }
}
