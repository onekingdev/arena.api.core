<?php

namespace Tests\Unit\Soundblock\Contracts;

use App\Models\Core\Auth\AuthModel;
use Tests\TestCase;
use App\Helpers\Util;
use App\Models\Core\App;
use Laravel\Passport\Passport;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Support\Facades\Config;
use App\Models\Users\User as UserModel;
use App\Models\Core\Auth\AuthPermission;
use App\Models\Users\Contact\UserContactEmail;
use App\Models\Soundblock\Projects\Team as TeamModel;
use App\Models\Soundblock\Accounts\Account as ServiceModel;
use App\Models\Soundblock\Projects\Project as ProjectModel;
use App\Models\Soundblock\Accounts\Account as SoundblockServiceModel;
use App\Models\Users\Contact\UserContactEmail as UserContactEmailModel;
use App\Models\Soundblock\Projects\Contracts\Contract as ContractModel;
use App\Contracts\Soundblock\Contracts\SmartContracts as SmartContractsContract;

class SmartContractTest extends TestCase {
    private UserModel $user;
    private ProjectModel $projectModel;
    private ContractModel $contractModel;
    private SoundblockServiceModel $serviceModel;
    private SmartContractsContract $contractService;
    private $userWithoutPermission;
    private $objAuth;

    public function setUp(): void {
        parent::setUp();

        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->make(["user_uuid" => $this->user->user_uuid]));

        $this->serviceModel = ServiceModel::factory()->create([
            "user_id"   => $this->user->user_id,
            "user_uuid" => $this->user->user_uuid,
        ]);
        $this->projectModel = $this->serviceModel->projects()->save(ProjectModel::factory()->make());
        $this->contractModel = $this->projectModel->contracts()->create([
            "contract_uuid"    => Util::uuid(),
            "service_id"       => $this->serviceModel->service_id,
            "service_uuid"     => $this->serviceModel->service_uuid,
            "project_uuid"     => $this->projectModel->project_uuid,
            "flag_status"      => "Active",
            "contract_version" => 1,
        ]);
        $this->projectModel->team()->save(TeamModel::factory()
                                                   ->make(["project_uuid" => $this->projectModel->project_uuid]));
        $this->contractService = resolve(SmartContractsContract::class);

        $_SERVER["HTTP_X_API"] = "v1.0";
        $_SERVER["HTTP_X_API_HOST"] = "app.arena.office.web";


        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);


        $this->user = UserModel::factory()->create();
        $this->user->emails()->save(UserContactEmailModel::factory()->primary()
                                                         ->make(["user_uuid" => $this->user->user_uuid]));

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

        $this->objAuth = AuthModel::where("auth_name", "App.Soundblock")->first();
        AuthGroup::factory()->create([
            "auth_id"    => $this->objAuth->auth_id,
            "auth_uuid"  => $this->objAuth->auth_uuid,
            "group_name" => Util::makeGroupName($this->objAuth, "project", $this->projectModel),
        ]);

        $this->userWithoutPermission = UserModel::factory()->create();

        $objUsers = UserModel::all();

        foreach ($objUsers as $objUser) {
            if (is_null($objUser->primary_email)) {
                $objUser->emails()->save(UserContactEmail::factory()->make(["user_uuid" => $objUser->user_uuid]));
            }

            $objUser->services()->attach($this->serviceModel->service_id, [
                "row_uuid"      => Util::uuid(),
                "service_uuid"  => $this->serviceModel->service_uuid,
                "user_uuid"     => $objUser->user_uuid,
                "flag_accepted" => true,
            ]);
        }
    }

    public function testCreate() {
        Passport::actingAs($this->user);
        $objUsers = UserModel::all();

        $arrMembers = [
            "members" => [
                [
                    "uuid"   => $objUsers[0]["user_uuid"],
                    "payout" => 50,
                    "role"   => "test",
                ],
                [
                    "uuid"   => $objUsers[1]["user_uuid"],
                    "payout" => 50,
                    "role"   => "test",
                ],
            ],
        ];

        $objProjectContract = $this->contractService->create($this->projectModel, $this->serviceModel, $arrMembers);

        $this->assertInstanceOf(ContractModel::class, $objProjectContract);
        $this->assertArrayHasKey("flag_status", $objProjectContract);
        $this->assertArrayHasKey("stamp_begins", $objProjectContract);
        $this->assertArrayHasKey("project_uuid", $objProjectContract);
        $this->assertArrayHasKey("service_uuid", $objProjectContract);
        $this->assertArrayHasKey("contract_uuid", $objProjectContract);
        $this->assertArrayHasKey("stamp_created", $objProjectContract);
        $this->assertArrayHasKey("stamp_updated", $objProjectContract);
        $this->assertArrayHasKey("contract_version", $objProjectContract);
        $this->assertArrayHasKey("stamp_created_by", $objProjectContract);
        $this->assertArrayHasKey("stamp_updated_by", $objProjectContract);
        $this->assertArrayHasKey("stamp_updated_at", $objProjectContract);
        $this->assertArrayHasKey("stamp_created_at", $objProjectContract);
    }

    public function testCreateWithOneMember() {
        Passport::actingAs($this->user);
        /* Set Global App */
        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);

        $arrMembers = [
            "members" => [
                [
                    "uuid"   => $this->user->user_uuid,
                    "payout" => 50,
                    "role"   => "test",
                ],
            ],
        ];

        $objProjectContract = $this->contractService->create($this->projectModel, $this->serviceModel, $arrMembers);

        $this->assertInstanceOf(ContractModel::class, $objProjectContract);
        $this->assertEquals("Active", $objProjectContract["flag_status"]);
    }

    public function testCreateWithOneMemberWithoutAccepting() {
        Passport::actingAs($this->user);
        /* Set Global App */
        $objApp = App::where("app_name", "soundblock")->first();
        Config::set("global.app", $objApp);
        $objUser = UserModel::first();

        $arrMembers = [
            "members" => [
                [
                    "uuid"   => $objUser->user_uuid,
                    "payout" => 100,
                    "role"   => "test",
                ],
            ],
        ];

        $objProjectContract = $this->contractService->create($this->projectModel, $this->serviceModel, $arrMembers);

        $this->assertInstanceOf(ContractModel::class, $objProjectContract);
        $this->assertEquals("Pending", $objProjectContract["flag_status"]);
    }

    public function testFind() {
        $objContract = $this->contractService->find($this->contractModel->contract_uuid);

        $this->assertInstanceOf(ContractModel::class, $objContract);
        $this->assertEquals($objContract->contract_uuid, $this->contractModel->contract_uuid);
        $this->assertArrayHasKey("flag_status", $objContract);
        $this->assertArrayHasKey("service_uuid", $objContract);
        $this->assertArrayHasKey("project_uuid", $objContract);
        $this->assertArrayHasKey("contract_uuid", $objContract);
        $this->assertArrayHasKey("contract_version", $objContract);
    }

    public function testUpdate() {
        Passport::actingAs($this->user);
        $objUsers = UserModel::all();

        $arrMembers = [
            "members" => [
                [
                    "uuid"   => $objUsers[0]["user_uuid"],
                    "payout" => 50,
                    "role"   => "test",
                ],
                [
                    "uuid"   => $objUsers[1]["user_uuid"],
                    "payout" => 50,
                    "role"   => "test",
                ],
            ],
        ];

        $objContract = $this->contractService->update($this->contractModel, $arrMembers);

        $this->assertInstanceOf(ContractModel::class, $objContract);
        $this->assertArrayHasKey("flag_status", $objContract);
        $this->assertArrayHasKey("service_uuid", $objContract);
        $this->assertArrayHasKey("project_uuid", $objContract);
        $this->assertArrayHasKey("contract_uuid", $objContract);
        $this->assertArrayHasKey("contract_version", $objContract);
    }

    public function testFindLatest() {
        $objContract = $this->contractService->findLatest($this->projectModel);

        $this->assertInstanceOf(ContractModel::class, $objContract);
        $this->assertArrayHasKey("flag_status", $objContract);
        $this->assertArrayHasKey("service_uuid", $objContract);
        $this->assertArrayHasKey("project_uuid", $objContract);
        $this->assertArrayHasKey("contract_uuid", $objContract);
        $this->assertArrayHasKey("contract_version", $objContract);
    }

    public function testAcceptContract() {
        $this->contractModel->users()->attach($this->user->user_id, [
            "row_uuid"        => Util::uuid(),
            "user_uuid"       => $this->user->user_uuid,
            "contract_uuid"   => $this->contractModel->contract_uuid,
            "contract_status" => "Pending",
            "user_payout"     => 100,
            "flag_action"     => "",
        ]);
        $objContract = $this->contractService->acceptContract($this->contractModel, $this->user);

        $this->assertInstanceOf(ContractModel::class, $objContract);
        $this->assertArrayHasKey("flag_status", $objContract);
        $this->assertArrayHasKey("service_uuid", $objContract);
        $this->assertArrayHasKey("project_uuid", $objContract);
        $this->assertArrayHasKey("contract_uuid", $objContract);
        $this->assertArrayHasKey("contract_version", $objContract);
    }

    public function testRejectContract() {
        $objContract = $this->contractService->rejectContract(ContractModel::find(2), UserModel::find(3));

        $this->assertInstanceOf(ContractModel::class, $objContract);
        $this->assertEquals($objContract->flag_status, "Rejected");
        $this->assertArrayHasKey("flag_status", $objContract);
        $this->assertArrayHasKey("service_uuid", $objContract);
        $this->assertArrayHasKey("project_uuid", $objContract);
        $this->assertArrayHasKey("contract_uuid", $objContract);
        $this->assertArrayHasKey("contract_version", $objContract);
    }

    public function testCheckAccess() {
        $boolResult = $this->contractService->checkAccess(ContractModel::find(2), UserModel::find(3));

        $this->assertTrue($boolResult);
    }

    public function testGetContractInfo() {
        $objContract = $this->contractService->getContractInfo($this->contractModel);

        $this->assertInstanceOf(ContractModel::class, $objContract);
        $this->assertEquals($objContract->contract_uuid, $this->contractModel->contract_uuid);
    }

    public function testCanModify() {
        $boolResult = $this->contractService->canModify(ContractModel::find(2));

        $this->assertIsBool($boolResult);
    }

    public function testRemindUser() {
        Passport::actingAs($this->user);
        $objUsers = UserModel::all();

        $arrMembers = [
            "members" => [
                [
                    "uuid"   => $objUsers[0]["user_uuid"],
                    "payout" => 50,
                    "role"   => "test",
                ],
                [
                    "uuid"   => $objUsers[1]["user_uuid"],
                    "payout" => 50,
                    "role"   => "test",
                ],
            ],
        ];

        $objProjectContract = $this->contractService->create($this->projectModel, $this->serviceModel, $arrMembers);
        $objProjectContract->users()->where("soundblock_projects_contracts_users.user_uuid", $objUsers[0]["user_uuid"])
                           ->update([
                               "soundblock_projects_contracts_users.stamp_remind" => time() - 86500,
                           ]);
        $boolResult = $this->contractService->sendReminders($objProjectContract, ["user_uuid" => $objUsers[0]["user_uuid"]]);

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }

    public function testRemindInvite() {
        Passport::actingAs($this->user);
        $objUsers = UserModel::all();

        $arrMembers = [
            "members" => [
                [
                    "email"  => rand(100, 10000) . "@arena.com",
                    "name"   => "Djamshut",
                    "payout" => 50,
                    "role"   => "test",
                ],
            ],
        ];

        $objProjectContract = $this->contractService->create($this->projectModel, $this->serviceModel, $arrMembers);
        $objInvite = $objProjectContract->contractInvites[0];
        $objProjectContract->contractInvites()
                           ->where("soundblock_projects_contracts_users.invite_uuid", $objInvite->invite_uuid)
                           ->update(["soundblock_projects_contracts_users.stamp_remind" => time() - 86500]);

        $boolResult = $this->contractService->sendReminders(
            $objProjectContract,
            ["invite_uuid" => $objProjectContract->contractInvites[0]->invite_uuid]
        );

        $this->assertIsBool($boolResult);
        $this->assertTrue($boolResult);
    }
}
