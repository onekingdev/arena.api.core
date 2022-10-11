<?php

namespace Tests\Feature\Finance;

use App\Models\Users\Contact\UserContactEmail;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Users\User;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Accounting\AccountingTypeRate;

class ChargeTypesManagingTest extends TestCase {
    /**
     * @var User
     */
    private $user;
    /**
     * @var User
     */
    private $userWithoutPermission;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));

        /** @var App $objApp */
        $objApp = App::where("app_name", "office")->first();

        /** @var AuthGroup $objGroup */
        $objGroup = AuthGroup::where("group_name", "App.Office")->first();
        $objGroup->users()->attach($this->user->user_id, [
            "row_uuid"   => Util::uuid(),
            "user_uuid"  => $this->user->user_uuid,
            "group_uuid" => $objGroup->group_uuid,
            "app_id"     => $objApp->app_id,
            "app_uuid"   => $objApp->app_uuid,
        ]);

        /** @var AuthPermission $objPermission */
        $objPermission = AuthPermission::where("permission_name", "App.Office.Access")->first();
        $objPermission->pusers()->attach($this->user->user_id, [
            "row_uuid"         => Util::uuid(),
            "group_id"         => $objGroup->group_id,
            "group_uuid"       => $objGroup->group_uuid,
            "user_uuid"        => $this->user->user_uuid,
            "permission_uuid"  => $objPermission->permission_uuid,
            "permission_value" => true,
        ]);

        $this->userWithoutPermission = User::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetCharges() {
        Passport::actingAs($this->user);

        $response = $this->get("/office/accounting/charge/rates");

        $response->assertStatus(200);
        $response->assertJsonFragment(["message" => "Type rates get successfully."]);
        $response = json_decode($response->getContent(), true);
        foreach($response["data"] as $item){
            $this->assertArrayHasKey("row_uuid", $item);
            $this->assertArrayHasKey("accounting_type_uuid", $item);
            $this->assertArrayHasKey("accounting_version", $item);
            $this->assertArrayHasKey("accounting_rate", $item);
            $this->assertArrayHasKey("stamp_created", $item);
            $this->assertArrayHasKey("stamp_created_by", $item);
            $this->assertArrayHasKey("stamp_updated", $item);
            $this->assertArrayHasKey("stamp_updated_by", $item);
        }
    }

    public function testGetChargesWithoutPermissions() {
        Passport::actingAs($this->userWithoutPermission);
        $response = $this->get("/office/accounting/charge/rates");
        $response->assertStatus(403);
        $response->assertJsonFragment([
            "message" => "You don't have required permissions.",
        ]);
    }

    public function testSaveChargeRates() {
        $arrData = [
            "rates" => [
                "contract" => 1.00,
                "user"     => 2.00,
                "download" => 3.00,
                "upload"   => 4.00,
            ],
        ];
        Passport::actingAs($this->user);

        $beforeChargeVersion = AccountingTypeRate::max("accounting_version");

        $response = $this->post("/office/accounting/charge/rates", $arrData);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                [
                    "accounting_type_uuid",
                    "accounting_type_name",
                    "accounting_type_memo",
                    "accountingtyperates" => [
                        "data" => [
                            [
                                "row_uuid",
                                "accounting_type_uuid",
                                "accounting_version",
                                "accounting_rate",
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertJsonFragment([
            "accounting_version" => $beforeChargeVersion + 1,
        ]);

        $this->assertDatabaseHas("accounting_types_rates", ["accounting_version" => $beforeChargeVersion + 1]);
        $afterChargeVersion = AccountingTypeRate::max("accounting_version");
        $this->assertGreaterThan($beforeChargeVersion, $afterChargeVersion);
    }

    public function testSaveRatesValidation() {
        $arrInvalidKeyData = [
            "rates" => [
                "contract"   => 1.00,
                "invalidKey" => 2.00,
                "download"   => 3.00,
                "upload"     => 4.00,
            ],
        ];
        Passport::actingAs($this->user);

        $responseRequiredValidationError = $this->post("/office/accounting/charge/rates");
        $responseRequiredValidationError->assertJsonValidationErrors("rates");
        $responseRequiredValidationError->assertJsonFragment([
            "rates" => [
                "The rates field is required."
            ]
        ]);

        $responseInvalidKeyValidationError = $this->post("/office/accounting/charge/rates", $arrInvalidKeyData);
        $responseInvalidKeyValidationError->assertJsonValidationErrors("rates");
        $responseInvalidKeyValidationError->assertJsonFragment([
            "rates" => [
                "Rate's array is not valid."
            ]
        ]);

        $arrInvalidCountData = [
            "rates" => [
                "contract"   => 1.00,
                "download"   => 3.00,
                "upload"     => 4.00,
            ],
        ];

        $responseInvalidKeyValidationError = $this->post("/office/accounting/charge/rates", $arrInvalidCountData);
        $responseInvalidKeyValidationError->assertJsonValidationErrors("rates");
        $responseInvalidKeyValidationError->assertJsonFragment([
            "rates" => [
                "Rate's array is not valid."
            ]
        ]);
    }

    public function testSaveChargesRatesWithoutPermissions() {
        $arrData = [
            "rates" => [
                "contract" => 1.00,
                "user"     => 2.00,
                "download" => 3.00,
                "upload"   => 4.00,
            ],
        ];

        Passport::actingAs($this->userWithoutPermission);
        $response = $this->post("/office/accounting/charge/rates", $arrData);
        $response->assertStatus(403);
        $response->assertJsonFragment([
            "message" => "You don't have required permissions.",
        ]);
    }
}
