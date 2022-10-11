<?php

namespace Tests\Unit\Core\Services\Support;

use Tests\TestCase;
use App\Models\Core\App;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Config;
use App\Models\Users\User as UserModel;
use App\Models\Support\Support as SupportModel;
use App\Models\Core\Auth\AuthGroup as AuthGroupModel;
use App\Services\Office\SupportTicket as SupportTicketService;
use App\Models\Support\Ticket\SupportTicket as SupportTicketModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;

class TicketTest extends TestCase {
    private SupportTicketService $supportService;
    private UserModel $user;
    private App $objApp;
    private SupportModel $objSupport;
    private SupportTicketModel $objTicket;

    public function setUp(): void {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->objApp = App::where("app_name", "office")->first();
        $this->supportService =  resolve(SupportTicketService::class);

        $this->objSupport = SupportModel::factory()->create();
        $this->objTicket = SupportTicketModel::factory()->create([
            "support_id" => $this->objSupport->support_id,
            "support_uuid" => $this->objSupport->support_uuid,
            "user_id" => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid,
        ]);
    }

    public function testCreteOfficeTicket(){
        Passport::actingAs($this->user);
        Config::set("global.app", $this->objApp);
        $arrParams = [
            "title"   => "Test2",
            "support" => "Customer Account",
            "from" => $this->user->user_uuid,
            "from_type" => "user",
            "message" => [
                "text" => "Lorem ipsum..."
            ]
        ];
        $objTicket = $this->supportService->creteOfficeTicket($this->user, $arrParams);

        $this->assertInstanceOf(SupportTicketModel::class, $objTicket);
        $this->assertEquals("Test2", $objTicket->ticket_title);
    }

    public function testCreteCoreTicket(){
        Passport::actingAs($this->user);
        Config::set("global.app", $this->objApp);
        $objAuthGroup = AuthGroupModel::where("group_name", "App.Office.Support")->first();
        $arrParams = [
            "title"   => "Test3",
            "support" => "Customer Account",
            "message" => [
                "text" => "Lorem ipsum..."
            ]
        ];
        $objTicket = $this->supportService->creteCoreTicket($this->user, $objAuthGroup, $this->objApp, $arrParams);

        $this->assertInstanceOf(SupportTicketModel::class, $objTicket);
        $this->assertEquals("Test3", $objTicket->ticket_title);
    }

    public function testFindAll(){
        $objTickets = $this->supportService->findAll([]);

        $this->assertEquals(SupportTicketModel::count(), $objTickets->total());
    }

    public function testCheckTicketUserForCore(){
        $objUser = UserModel::where("user_uuid", $this->objTicket->user_uuid)->first();
        $objTicket = $this->supportService->checkTicketUserForCore($objUser, $this->objTicket->ticket_uuid);

        $this->assertEquals($this->objTicket->ticket_uuid, $objTicket->ticket_uuid);
        $this->assertEquals($objUser->user_uuid, $objTicket->user_uuid);
    }

    public function testFind(){
        $objTicket = $this->supportService->find($this->objTicket->ticket_uuid);

        $this->assertEquals($this->objTicket->ticket_uuid, $objTicket->ticket_uuid);
    }

    public function testUpdate(){
        $objTicket = $this->supportService->update($this->objTicket, ["flag_status" => "Closed"]);

        $this->assertEquals("Closed", $objTicket->flag_status);
    }

    public function testEdit(){
        $arrParams = [
            "to_type" => "user",
            "to" => [
                $this->user->user_uuid
            ]
        ];
        $boolResult = $this->supportService->edit($this->objTicket, $arrParams);

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }

    public function testCheckAccessToTicket(){
        $objOldTicket = SupportTicketModel::whereHas("supportUser", function ($query) {
            $query->where("flag_active", true);
        })->first();
        $objUser = UserModel::where("user_uuid", $objOldTicket->supportUser[0]->user_uuid)->first();
        $groups = collect();
        $boolResult = $this->supportService->checkAccessToTicket($objOldTicket, $objUser, $groups, true);

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }

    public function testCheckTicketEqualUser(){
        $objOldTicket = SupportTicketModel::whereHas("supportUser")->first();
        $objUser = UserModel::where("user_uuid", $objOldTicket->supportUser[0]->user_uuid)->first();
        $boolResult = $this->supportService->checkTicketEqualUser($objOldTicket, $objUser);

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }
}
