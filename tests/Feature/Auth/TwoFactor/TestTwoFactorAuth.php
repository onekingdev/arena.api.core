<?php

namespace Tests\Feature\Auth\TwoFactor;

use Tests\TestCase;
use App\Helpers\Util;
use App\Helpers\Client;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use App\Models\Users\Contact\UserContactEmail;
use PragmaRX\Google2FALaravel\Facade as TwoFactorFacade;


class TestTwoFactorAuth extends TestCase {
    public function setUp(): void {
        parent::setUp();

        Client::checkingAs();
        $_ENV["PASSWORD_CLIENT_SECRET"] = DB::table("oauth_clients")->where("id", 2)->value("secret");
    }

    /**
     * A basic feature test example.
     *
     * @return void
     * @throws \Exception
     */
    public function testAuthWithEnabledTwoFactor() {
        /** @var User $user */
        $user = User::factory()->create();

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);


        $objEmail = $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"      => Util::uuid(),
            "user_uuid"     => $user->user_uuid,
            "flag_primary"  => true,
            "flag_verified" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $twoFactorCode = TwoFactorFacade::getCurrentOtp($secret);

        $arrRequestData = [
            "user"     => $objEmail->user_auth_email,
            "password" => "password",
            "2fa_code" => $twoFactorCode,
        ];

        $response = $this->post("/core/auth/signin", $arrRequestData);

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
    }

    public function testAuthFailWithEnabledTwoFactor() {
        /** @var User $user */
        $user = User::factory()->create();

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);


        $objEmail = $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"      => Util::uuid(),
            "user_uuid"     => $user->user_uuid,
            "flag_primary"  => true,
            "flag_verified" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $arrRequestData = [
            "user"     => $objEmail->user_auth_email,
            "password" => "password",
        ];

        $response = $this->post("/core/auth/signin", $arrRequestData);

        $response->assertStatus(449);
        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);
        $response->assertJsonFragment(["message" => "2FA Code Required."]);
    }

    public function testAuthWithInvalidCode() {
        /** @var User $user */
        $user = User::factory()->create();

        $secret = TwoFactorFacade::generateSecretKey();
        $user->loginSecurity()->create([
            "row_uuid"         => Util::uuid(),
            "user_uuid"        => $user->user_uuid,
            "google2fa_secret" => $secret,
            "flag_enabled"     => true,
        ]);


        $objEmail = $user->emails()->create(UserContactEmail::factory()->make([
            "row_uuid"      => Util::uuid(),
            "user_uuid"     => $user->user_uuid,
            "flag_primary"  => true,
            "flag_verified" => true,
        ])->makeVisible(["row_uuid", "user_uuid"])->toArray());

        $arrRequestData = [
            "user"     => $objEmail->user_auth_email,
            "password" => "password",
            "2fa_code" => 1,
        ];

        $response = $this->post("/core/auth/signin", $arrRequestData);

        $response->assertStatus(400);
        $response->assertJsonStructure([
            "data",
            "status" => [
                "app",
                "code",
                "message",
            ],
        ]);
        $response->assertJsonFragment(["message" => "2FA Code Is Invalid."]);
    }
}
