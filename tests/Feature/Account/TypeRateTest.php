<?php

namespace Tests\Feature\Core;

use App\Models\Accounting\AccountingType as AccountingTypeModel;
use App\Models\Users\Contact\UserContactEmail;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Users\User;
use App\Models\Core\AppsPage;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Accounting\AccountingTypeRate as AccountingTypeRateModel;

class TypeRateTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $userWithoutPermission;
    private AccountingTypeRateModel $typeRate;
    /**
     * @var User
     */
    private User $user;
    private AppsPage $page;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->page = AppsPage::first();

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

        $accountingType = AccountingTypeModel::factory()->create();
        $this->typeRate = $accountingType->accountingTypeRates()->create(AccountingTypeRateModel::factory()->make([
            "accounting_type_id" => $accountingType->accounting_type_id,
            "accounting_type_uuid" => $accountingType->accounting_type_uuid,
        ])->setHidden([])->toArray());    }

    public function testGetCharges(){
        Passport::actingAs($this->user);

        $response = $this->get("office/accounting/invoice/type/rate");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                [
                    "row_uuid",
                    "accounting_type_uuid",
                    "accounting_version",
                    "accounting_rate",
                    "stamp_created",
                    "stamp_created_by",
                    "stamp_updated",
                    "stamp_updated_by",
                ]
            ],
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
    }

    public function testSaveCharges(){
        Passport::actingAs($this->user);

        $response = $this->post(
            "office/accounting/invoice/type/rate",
            [ "rates" => [ "contract" => 10, "user" => 10.99, "upload" => 10, "download" => 10 ] ]
        );

        $response->assertStatus(200);
        $response = json_decode($response->getContent(), true);
        foreach($response["data"] as $item){
            $this->assertArrayHasKey("accounting_type_uuid", $item);
            $this->assertArrayHasKey("accounting_type_name", $item);
            $this->assertArrayHasKey("accounting_type_memo", $item);
            $this->assertArrayHasKey("accountingtyperates", $item);
            $this->assertArrayHasKey("data", $item["accountingtyperates"]);
            $this->assertArrayHasKey("data", $item["accountingtyperates"]);
        }
    }

    public function testUpdateTypeRate(){
        Passport::actingAs($this->user);

        $response = $this->patch(
            "office/accounting/invoice/type/rate/" . $this->typeRate->row_uuid,
            [ "accounting_type_uuid" => $this->typeRate->accounting_type_uuid, "accounting_rate" => 10 ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
        $response->assertJsonFragment(["message" => "Type rate updated successfully."]);
    }

    public function testDeleteTypeRate(){
        Passport::actingAs($this->user);

        $response = $this->delete("office/accounting/invoice/type/rate/" . $this->typeRate->row_uuid);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
        $response->assertJsonFragment(["message" => "Type rate deleted successfully."]);
    }
}
