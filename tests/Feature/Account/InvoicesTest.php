<?php

namespace Tests\Feature\Core;

use App\Models\Users\Contact\UserContactEmail;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use App\Models\Users\User;
use App\Models\Core\AppsPage;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Accounting\AccountingType as AccountingTypeModel;
use App\Models\Accounting\AccountingInvoice as AccountingInvoiceModel;

class InvoicesTest extends TestCase
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $userWithoutPermission;
    private $invoice;
    private $accountingType;
    /**
     * @var User|null
     */
    private ?User $user;
    private ?AppsPage $page;

    public function setUp(): void {
        parent::setUp();

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";

        $this->user = User::factory()->create();
        $this->user->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $this->user->user_uuid]));
        $this->page = AppsPage::first();
        $this->accountingType = AccountingTypeModel::factory()->create();

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
        $this->invoice = AccountingInvoiceModel::first();
    }

    public function testGetInvoices(){
        Passport::actingAs($this->user);

        $response = $this->get("/office/accounting/invoice/all/invoices?per_page=10");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "current_page",
            "data" => [
                [
                    "invoice_uuid",
                    "app_uuid",
                    "user_uuid",
                    "invoice_date",
                    "invoice_amount",
                    "invoice_status",
                    "invoice_coupon",
                    "invoice_discount",
                    "stamp_created",
                    "stamp_created_by",
                    "stamp_updated",
                    "stamp_updated_by",
                    "stamp_discount",
                    "stamp_discount_by",
                    "payment_detail",
                    "invoice_type",
                    "transactions",
                ]
            ],
            "first_page_url",
            "from",
            "last_page",
            "last_page_url",
            "next_page_url",
            "path",
            "per_page",
            "prev_page_url",
            "to",
            "total"
        ]);
    }

    public function testGetUserInvoices(){
        Passport::actingAs($this->user);

        $response = $this->get("/office/accounting/invoice/user/invoices");
        $response->assertStatus(200);
    }

    public function testGetInvoiceByUuid(){
        Passport::actingAs($this->user);

        $response = $this->get("/office/accounting/invoice/" . $this->invoice->invoice_uuid . "");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "payment",
                "transactions",
                "invoice_type",
                "payment_details",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
                "app",
            ]
        ]);
    }

    public function testGetInvoiceType(){
        Passport::actingAs($this->user);

        $response = $this->get("/office/accounting/invoice/" . $this->invoice->invoice_uuid . "/type");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "type_code",
                "type_uuid",
                "type_name",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
            ]
        ]);
    }

    public function testGetInvoiceTypes(){
        Passport::actingAs($this->user);

        $response = $this->get("/office/accounting/invoice/all/types");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                [
                    "type_code",
                    "type_uuid",
                    "type_name",
                    "stamp_created",
                    "stamp_created_by",
                    "stamp_updated",
                    "stamp_updated_by",
                ]
            ]
        ]);
    }

    public function testCreateInvoiceType(){
        Passport::actingAs($this->user);

        $response = $this->post("/office/accounting/invoice/type", ["accounting_type_name" => "someTestName", "accounting_type_memo" => "testMemo"]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "accounting_type_name",
                "accounting_type_memo",
                "accounting_type_uuid",
                "stamp_created",
                "stamp_created_by",
                "stamp_updated",
                "stamp_updated_by",
            ],
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
        $response->assertJsonFragment(["accounting_type_name" => "someTestName"]);
        $response->assertJsonFragment(["message" => "New type created successfully."]);
    }

    public function testUpdateInvoiceType(){
        Passport::actingAs($this->user);

        $response = $this->patch(
            "/office/accounting/invoice/type/" . $this->accountingType->accounting_type_uuid,
            ["accounting_type_name" => "updatedTestName", 'accounting_type_memo' => "updatedTestMemo"]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
        $response->assertJsonFragment(["message" => "Invoice type updated successfully."]);
    }

    public function testDeleteInvoiceType(){
        Passport::actingAs($this->user);

        $response = $this->delete("/office/accounting/invoice/type/" . $this->accountingType->accounting_type_uuid);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "status" => [
                "app",
                "code",
                "message"
            ]
        ]);
        $response->assertJsonFragment(["message" => "Invoice type deleted successfully."]);
    }
}
