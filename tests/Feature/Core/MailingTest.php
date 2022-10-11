<?php

namespace Tests\Feature\Core;

use Tests\TestCase;
use App\Models\Core\Mailing\Email as EmailModel;

class MailingTest extends TestCase
{
    private ?EmailModel $email;

    public function setUp(): void
    {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->email = EmailModel::first();
    }

    public function testAddEmail(){
        $strEmail = "featureTes".time()."t@email.com";
        $response = $this->post("/core/mailing/email", ["email" => $strEmail, "beta_user" => false]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "email",
                "row_uuid",
                "stamp_created",
                "stamp_updated",
                "stamp_created_by",
                "stamp_updated_by",
            ],
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
        $response->assertJsonFragment(["email" => $strEmail]);
        $response->assertJsonFragment(["message" => "Email added successfully."]);
    }
}
