<?php

namespace Tests\Feature\Auth\TwoFactor;

use Tests\TestCase;
use App\Helpers\Util;
use App\Helpers\Client;
use App\Models\Users\User;
use Laravel\Passport\Passport;
use PragmaRX\Google2FALaravel\Facade as TwoFactorFacade;

class TestSecrets extends TestCase {
    public function setUp(): void {
        parent::setUp();

        Client::checkingAs();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateSecrets() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->post('/core/auth/2fa/secret');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "secret",
                "qrCode",
                "url",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $this->assertDatabaseHas("users_login_security", [
            "user_id"      => $user->user_id,
            "flag_enabled" => false,
        ]);

        $user->refresh();
        $objLoginSecurity = $user->loginSecurity;

        $response->assertJsonFragment([
            "secret" => $objLoginSecurity->google2fa_secret,
        ]);
    }

    public function testCreateSecretsWithEnabled2FA() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);

        $response = $this->post('/core/auth/2fa/secret');
        $response->assertStatus(400);
        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment(["message" => "You Already Have 2FA Secrets."]);
    }

    public function testGetSecrets() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);

        $response = $this->get('/core/auth/2fa/secret');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data"   => [
                "secret",
                "qrCode",
                "url",
            ],
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);
        $response->assertJsonFragment([
            "secret" => $secret,
        ]);
    }

    public function testGetSecretsWithoutSecrets() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);
        $response = $this->get('/core/auth/2fa/secret');
        $response->assertStatus(400);

        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment(["message" => "You Haven't 2FA Secrets."]);
    }

    public function testDisableTwoFactor() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);

        $response = $this->delete('/core/auth/2fa/secret');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment(["message" => "You Have Successfully Disabled 2FA"]);

        $this->assertDatabaseHas("users_login_security", [
            "user_id"      => $user->user_id,
            "flag_enabled" => false,
        ]);
    }

    public function testDisableTwoFactorWithoutSecrets() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->delete('/core/auth/2fa/secret');
        $response->assertStatus(400);

        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment(["message" => "You Haven't Enabled 2FA."]);
    }

    public function testVerify2FA() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $secret = TwoFactorFacade::generateSecretKey();
        $objLs = $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => false,
        ]);

        $response = $this->post('/core/auth/2fa/verify', [
            "auth_code" => TwoFactorFacade::getCurrentOtp($secret),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);
        $response->assertJsonFragment(["message" => "You Have Successfully Verify 2FA."]);

        $this->assertDatabaseHas("users_login_security", [
            "row_id"       => $objLs->row_id,
            "flag_enabled" => true,
        ]);
    }

    public function testValidate2FAValidationError() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => false,
        ]);

        $response = $this->post('/core/auth/2fa/verify');
        $response->assertStatus(422);
        $response->assertJsonValidationErrors("auth_code");
    }

    public function testValidate2FAWithAlreadyVerified() {
        /** @var User $user */
        $user = User::factory()->create();

        Passport::actingAs($user);

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);

        $response = $this->post('/core/auth/2fa/verify', [
            "auth_code" => TwoFactorFacade::getCurrentOtp($secret),
        ]);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);

        $response->assertJsonFragment(["message" => "You Have Already Enabled 2FA."]);
    }
}
